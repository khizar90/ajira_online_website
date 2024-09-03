<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Auth\ChangePasswordRequest;
use App\Http\Requests\Api\Auth\LoginRequest;
use App\Http\Requests\Api\Auth\LogoutRequest;
use App\Http\Requests\Api\Auth\NewPasswordRequest;
use App\Http\Requests\Api\Auth\OtpVerifyRequest;
use App\Http\Requests\Api\Auth\RecoverVerifyRequest;
use App\Http\Requests\Api\Auth\RegisterRequest;
use App\Mail\ForgotOtp;
use App\Models\OtpVerify;
use App\Models\User;
use App\Models\UserDevice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    public function register(RegisterRequest $request)
    {
        $create = new User();
        $create->name = $request->name;
        $create->email = $request->email;
        $create->password = Hash::make($request->password);
        $create->country_code = $request->country_code;
        $create->phone = $request->phone;
        $create->phone_number = $request->phone_number;
        $create->country = $request->country;
        $create->payment_method = $request->payment_method;
        $create->update_allow = $request->update_allow ?: 0;
        $create->save();

        $userdevice = new UserDevice();
        $userdevice->user_id = $create->uuid;
        $userdevice->device_name = $request->device_name ?? 'No name';
        $userdevice->device_id = $request->device_id ?? 'No ID';
        $userdevice->timezone = $request->timezone ?? 'No Time';
        $userdevice->token = $request->fcm_token ?? 'No tocken';
        $userdevice->save();

        $user  = User::where('uuid', $create->uuid)->first();

        $user->token = $user->createToken('Register')->plainTextToken;
        return response()->json([
            'status' => true,
            'action' => 'User register successfully',
            'data' => $user
        ]);
    }

    public function login(LoginRequest $request)
    {
        $user = User::Where('email', $request->email)->first();
        if ($user) {
            if (Hash::check($request->password, $user->password)) {
                $userdevice = new UserDevice();
                $userdevice->user_id = $user->uuid;
                $userdevice->device_name = $request->device_name ?? 'No name';
                $userdevice->device_id = $request->device_id ?? 'No ID';
                $userdevice->timezone = $request->timezone ?? 'No Time';
                $userdevice->token = $request->fcm_token ?? 'No tocken';
                $userdevice->save();



                $user->token = $user->createToken('Login')->plainTextToken;

                return response()->json([
                    'status' => true,
                    'action' => "Login successfully",
                    'data' => $user,
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'title' => 'Authentication Error!',
                    'errors' => [
                        [
                            'field' => 'password',
                            'message' => "Oops! Incorrect password. Please double-check and try again."
                        ]
                    ]
                ]);
            }
        }
        return response()->json([
            'status' => false,
            'title' => 'Invalid Credentials',
            'errors' => [
                [
                    'field' => 'account',
                    'message' => 'Account not found'
                ]
            ]
        ]);
    }

    public function recover(RecoverVerifyRequest $request)
    {
        $user = User::where('email', $request->email)->first();
        if ($user) {
            $otp = random_int(100000, 999999);

            $userOtp = new OtpVerify();
            $userOtp->email = $request->email;
            $userOtp->otp = $otp;
            $userOtp->save();

            $mailDetails = [
                'body' => $otp,
                'name' => $user->name
            ];

            Mail::to($request->email)->send(new ForgotOtp($mailDetails));

            return response()->json([
                'status' => true,
                'action' => 'Otp send successfully',
            ]);
        } else {
            return response()->json([
                'status' => false,
                'title' => 'Validation Error!',
                'errors' => [
                    [
                        'field' => 'email',
                        'message' => "Oops! We couldn't find this email address in our records"
                    ]
                ]
            ]);
        }
    }

    public function otpVerify(OtpVerifyRequest $request)
    {
        $user = OtpVerify::where('email', $request->email)->latest()->first();
        if ($user) {
            if ($request->otp == $user->otp) {
                $user = OtpVerify::where('email', $request->email)->delete();
                return response()->json([
                    'status' => true,
                    'action' => 'OTP verify',
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'title' => 'Invalid OTP',
                    'errors' => [
                        [
                            'field' => 'otp',
                            'message' => 'The OTP you entered is invalid or expired. Please enter the correct OTP or request a new OTP and try again'
                        ]
                    ]
                ]);
            }
        }
    }

    public function newPassword(NewPasswordRequest $request)
    {
        $user = User::where('email', $request->email)->first();
        if ($user) {
            if (Hash::check($request->password, $user->password)) {
                return response()->json([
                    'status' => false,
                    'title' => 'Validation Error!',
                    'errors' => [
                        [
                            'field' => 'email',
                            'message' => "Your new password should be different from your old password."
                        ]
                    ]
                ]);
            } else {
                $user->update([
                    'password' => Hash::make($request->password)
                ]);
                $user->save();
                return response()->json([
                    'status' => true,
                    'action' => "New password set",
                ]);
            }

            return response()->json([
                'status' => true,
                'action' => "New Password set"
            ]);
        } else {
            return response()->json([
                'status' => false,
                'title' => 'Invalid Credentials',
                'errors' => [
                    [
                        'field' => 'account',
                        'message' => 'Account not found'
                    ]
                ]
            ]);
        }
    }


    public function logout(LogoutRequest $request)
    {
        $user  = User::find($request->user()->uuid);

        UserDevice::where('user_id', $user->uuid)->where('device_id', $request->device_id)->delete();
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'status' => true,
            'action' => 'User logged out'
        ]);
    }

    public function changePassword(ChangePasswordRequest $request)
    {
        $user = User::find($request->user()->uuid);
        if ($user) {
            if (Hash::check($request->old_password, $user->password)) {
                if (Hash::check($request->new_password, $user->password)) {
                    return response()->json([
                        'status' => false,
                        'title' => 'Same Password!',
                        'errors' => [
                            [
                                'field' => 'password',
                                'message' => 'Your new password should be different from your old password'
                            ]
                        ]
                    ]);
                } else {
                    $user->password = Hash::make($request->new_password);
                    $user->save();
                    return response()->json([
                        'status' => true,
                        'action' => "Password change",
                        'data' => $user

                    ]);
                }
            }
            return response()->json([
                'status' => false,
                'title' => 'Wrong Password!',
                'errors' => [
                    [
                        'field' => 'old_password',
                        'message' => 'Old password is wrong'
                    ]
                ]
            ]);
        } else {
            return response()->json([
                'status' => false,
                'action' => 'User not found'
            ]);
        }
    }
}
