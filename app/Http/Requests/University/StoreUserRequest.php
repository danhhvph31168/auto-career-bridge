<?php

namespace App\Http\Requests\University;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
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
            'username' => 'required|string|max:50,username',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif',
            'phone' => 'required|string|max:15|regex:/^[0-9]+$/|unique:users,phone',
            'role_id' => 'required|in:' . ROLE_ADMIN . ',' . ROLE_USER,
        ];
    }

    public function messages()
    {
        return [
            'username.required' => 'Tên người dùng là bắt buộc.',
            'username.max' => 'Tên người dùng không được vượt quá 50 ký tự.',

            'email.required' => 'Email là bắt buộc.',
            'email.unique' => 'Email này đã tồn tại.',
            'email.email' => 'Email không hợp lệ.',

            'password.required' => 'Mật khẩu là bắt buộc.',
            'password.min' => 'Mật khẩu phải chứa ít nhất 8 ký tự.',
            'password.confirmed' => 'Xác nhận mật khẩu không khớp.',

            'avatar.image' => 'Ảnh đại diện phải là một file ảnh.',
            'avatar.mimes' => 'Ảnh đại diện chỉ được có định dạng: jpeg, png, jpg, gif.',

            'phone.required' => 'Số điện thoại là bắt buộc.',
            'phone.regex' => 'Số điện thoại chỉ được chứa số.',
            'phone.max' => 'Số điện thoại không được vượt quá 15 ký tự.',
            'phone.unique' => 'Số điện thoại đã được sử dụng.',

            'role_id.required' => 'Vai trò là bắt buộc.',
            'role_id.in' => 'Vai trò không hợp lệ.',
        ];
    }
}
