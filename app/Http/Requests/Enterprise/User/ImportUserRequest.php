<?php

namespace App\Http\Requests\Enterprise\User;

use Illuminate\Foundation\Http\FormRequest;

class ImportUserRequest extends FormRequest
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
            'data' => ['required', 'array'],
            'data.*.username' => ['required', 'string', 'max:255'],
            'data.*.phone' => ['nullable', 'numeric', 'digits_between:1,11', 'unique:users'],
            'data.*.email' => ['required', 'max:255', 'email', 'unique:users'],
            'data.*.password' => ['required', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            'data.*.username.required' => ':attribute không được để trống',
            'data.*.username.string' => ':attribute: :input phải là kiểu chuỗi',
            'data.*.username.max' => ':attribute: :input không được vượt quá :max kí tự',

            'data.*.phone.required' => ':attribute: không được để trống',
            'data.*.phone.numeric' => ':attribute: :input phải là số',
            'data.*.phone.digits_between' => ':attribute: :input không được vượt quá 11 số',
            'data.*.phone.unique' => ':attribute: :input đã tồn tại',

            'data.*.email.required' => ':attribute không được để trống',
            'data.*.email.max' => ':attribute: :input không được vượt quá :max kí tự',
            'data.*.email.email' => ':attribute: :input không hợp lệ',
            'data.*.email.unique' => ':attribute: :input đã tồn tại',

            'data.*.password.required' => ':attribute không được để trống',
            'data.*.password.string' => ':attribute: :input phải là kiểu chuỗi',
        ];
    }
    public function attributes(): array
    {
        return [
            'data.*.username' => 'Họ và tên',
            'data.*.phone' => 'Số điện thoại',
            'data.*.email' => 'Email',
            'data.*.password' => 'Mật khẩu',
        ];
    }
}
