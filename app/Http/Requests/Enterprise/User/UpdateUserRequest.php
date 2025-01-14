<?php

namespace App\Http\Requests\Enterprise\User;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
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
        $id = $this->segment(3);

        return [
            'username' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'digits_between:1,11', 'numeric', "unique:users,phone,$id"],
            'email' => ['required', 'max:255', 'email', "unique:users,email,$id"],
            'password' => ['required', 'string'],
            're_password' => ['required', 'same:password'],
            'is_active' => ['required', 'in:' . IS_ACTIVE . ',' . UN_ACTIVE]
        ];
    }

    public function messages(): array
    {
        return [
            'username.required' => 'Họ và tên không được để trống',
            'username.string' => 'Họ và tên phải là kiểu chuỗi',
            'username.max' => 'Họ và tên không được vượt quá :max kí tự',

            'phone.required' => 'Số điện thoại không được để trống',
            'phone.numeric' => 'Số điện thoại phải là số',
            'phone.digits_between' => 'Số điện thoại không được vượt quá 11 số',
            'phone.unique' => 'Số điện thoại đã tồn tại',

            'email.required' => 'Email không được để trống',
            'email.max' => 'Email không được vượt quá :max kí tự',
            'email.email' => 'Email không hợp lệ',
            'email.unique' => 'Email đã tồn tại',

            'password.required' => 'Mật khẩu không được để trống',
            'password.string' => 'Mật khẩu là kiểu chuỗi',

            're_password.required' => 'Nhập lại mật khẩu không được để trống',
            're_password.same' => 'Nhập lại mật khẩu không giống nhau',

            'is_active.in' => 'Trạng thái không hợp lệ',
        ];
    }
}
