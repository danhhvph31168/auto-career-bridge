<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class ResetPasswordRequest extends FormRequest
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
            "email" => "required|regex:/^[\w\._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/|max:100|exists:users,email",
            'password' => [
                'required',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/',
                'confirmed',
            ],
            'token' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'email.required' => 'Email không được để trống',
            'email.regex' => 'Định dạng email không hợp lệ',
            'email.max' => 'Email không được vượt quá :max ký tự',
            'email.exists' => 'Email không tồn tại trong hệ thống.',
            'password.regex' => 'Mật khẩu phải có ít nhất 8 ký tự, bao gồm ít nhất một chữ hoa, một chữ thường, một chữ số và một ký tự đặc biệt',
            'password.required' => 'Mật khẩu không được để trống',
            'password.confirmed' => 'Mật khẩu xác nhận không khớp',
            'token.required' => 'Mã xác nhận không được để trống',
        ];
    }
}
