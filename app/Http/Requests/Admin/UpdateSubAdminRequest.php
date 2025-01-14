<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSubAdminRequest extends FormRequest
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
            'username' => 'required|string|max:50|unique:users,username,' . $this->route('sub_admin'),
            'email' => 'required|email|unique:users,email,' . $this->route('sub_admin'),
            'password' => 'nullable|strong_password|confirmed',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif',
            'phone' => 'required|regex:/^0[3-9]\d{8}$/|unique:users,phone,' . $this->route('sub_admin'),
        ];
    }

    public function messages()
    {
        return [
            'email.required' => 'Email bắt buộc nhập',
            'email.email' => 'Định dạng email không hợp lệ',
            'email.max' => 'Email không được vượt quá :max ký tự',
            'email.unique' => 'Email đã được sử dụng, vui lòng chọn email khác',
            'username.required' => 'Tên bắt buộc nhập',
            'username.max' => 'Tên không được vượt quá :max ký tự',
            'avatar.image' => 'Ảnh đại diện phải là một file ảnh.',
            'avatar.mimes' => 'Ảnh đại diện chỉ được có định dạng: jpeg, png, jpg, gif.',
            'phone.required' => 'Số điện thoại bắt buộc nhập',
            'phone.regex' => 'Số điện thoại không đúng định dạng',
            'phone.unique' => 'Số điện thoại đã tồn tại, vui lòng chọn số khác',
            'password.required' => 'Mật khẩu bắt buộc nhập',
            'password.strong_password' => 'Mật khẩu phải có ít nhất 8 ký tự, bao gồm ít nhất một chữ hoa và một ký tự đặc biệt',
            'password.confirmed' => 'Xác nhận mật khẩu không trùng khớp',
        ];
    }
}
