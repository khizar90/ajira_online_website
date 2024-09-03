<?php

namespace App\Http\Requests\Api\Auth;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class ChangePasswordRequest extends FormRequest
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
    public function rules()
    {
        return [
            'new_password' => 'required',
            'old_password' => 'required'
        ];
    }
    public function messages()
    {
        return [
            'old_password.required' => 'Please enter the Old Password',
            'new_password.required' => 'Please enter the New Password',
            'new_password.min' => 'Please enter atleast 6 characters in New Password',
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
