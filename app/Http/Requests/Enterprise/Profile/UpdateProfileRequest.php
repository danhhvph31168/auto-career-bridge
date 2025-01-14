<?php

namespace App\Http\Requests\Enterprise\Profile;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileRequest extends FormRequest
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
            'name' => 'required|string',
            'email' => 'required|email|unique:enterprises,email,' . $this->user()->enterprise_id,
            'phone' => 'required|string|regex:/^[0-9]{10,11}$/',
            'url' => 'required|url',
            'size' => 'nullable|numeric',
            'tax_code' => 'required',
            'address' => 'required|string',
        ];
    }

    /**
     * Get the custom validation messages for the request.
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Tên doanh nghiệp không được để trống.',
            'name.string' => 'Tên doanh nghiệp phải là một chuỗi.',

            'email.required' => 'Email không được để trống.',
            'email.email' => 'Email phải hợp lệ.',

            'email.unique' => 'Email đã tồn tại.',

            'phone.required' => 'Số điện thoại không được để trống.',
            'phone.regex' => 'Số điện thoại không hợp lệ.',

            'url.required' => 'Địa chỉ URL không được để trống.',
            'url.url' => 'Địa chỉ URL không hợp lệ.',

            'tax_code.required' => 'Mã số thuế không được bỏ trống.',

            'size.numeric' => 'Quy mô phải là số',

            'address.required' => 'Địa chỉ không được để trống.',
            'address.string' => 'Địa chỉ phải là chuỗi.',
        ];
    }
}
