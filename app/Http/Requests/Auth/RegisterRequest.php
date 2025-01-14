<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

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
            "email" => "required|regex:/^[\w\._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/|max:100|unique:users,email",
            "username" => "required|max:100",
            "phone" => "required|regex:/^0[3-9]\d{8}$/|unique:users",
            "password" => "required|strong_password",
            "password_confirmation" => [
                "required_with:password",
                "same:password",
            ],
            "user_type" => "required|in:university,enterprise"
        ];
    }

    public function messages()
    {
        return [
            'email.required' => 'Email bắt buộc nhập',
            'email.regex' => 'Định dạng email không hợp lệ',
            'email.max' => 'Email không được vượt quá :max ký tự',
            'email.unique' => 'Email đã được sử dụng, vui lòng chọn email khác',
            'username.required' => 'Tên bắt buộc nhập',
            'username.max' => 'Tên không được vượt quá :max ký tự',
            'phone.required' => 'Số điện thoại bắt buộc nhập',
            'phone.regex' => 'Số điện thoại không đúng định dạng',
            'phone.unique' => 'Số điện thoại đã tồn tại, vui lòng chọn số khác',
            'password.required' => 'Mật khẩu bắt buộc nhập',
            'password.strong_password' => 'Mật khẩu phải có ít nhất 8 ký tự, bao gồm ít nhất một chữ hoa, một chữ số, một chữ thường và một ký tự đặc biệt',
            'password_confirmation.required_with' => 'Chưa xác nhận mật khẩu',
            'password_confirmation.same' => 'Xác nhận mật khẩu không trùng khớp',
            'user_type.required' => 'Loại tài khoản bắt buộc chọn',
            'user_type.in' => 'Loại tài khoản không hợp lệ. Chỉ chấp nhận giá trị "Doanh nghiệp" hoặc "Nhà trường"',
        ];
    }
}
