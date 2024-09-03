<?php

namespace App\Http\Requests\Api\Auth;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required',
            'email' => 'required|unique:users,email|email',
            'country_code' => 'required',
            'phone' => 'required',
            'phone_number' => 'required|unique:users,phone_number',
            'country' => 'required',
            'password' => 'required',
            'payment_method' => 'required',
            'update_allow' => 'required',
        ];
    }
    public function messages()
    {
        return [
            'email.required' => 'Please enter the Email Address',
            'email.unique' => 'Oops! Email Address Already Exists',
            'email.email' => 'Please enter a valid Email Address',
            'password.required' => 'Please enter the Password',
            'name.required' => 'Please enter the Full Name',
            'country_code.required' => 'Please enter the Country Code',
            'phone.required' => 'Please enter the Phone',
            'phone_number.required' => 'Please enter the Phone Number',
            'phone_number.unique' => 'Oops! Phone Number Address Already Exists',
            'payment_method.required' => 'Please enter the Paymnet Method',
            'country.required' => 'Please enter the Country',
        ];
    }
    public function failedValidation(Validator $validator)
    {
        $errors = [];

        foreach ($validator->errors()->messages() as $field => $messages) {
            foreach ($messages as $message) {
                $errors[] = [
                    'field' => $field,
                    'message' => $message,
                ];
            }
        }


        throw new HttpResponseException(response()->json([
            'status'   => false,
            'title' => 'Validation Error!',
            'errors' => $errors
        ]));
    }
}
