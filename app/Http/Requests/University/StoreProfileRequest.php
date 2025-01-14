<?php

namespace App\Http\Requests\University;

use Illuminate\Foundation\Http\FormRequest;

class StoreProfileRequest extends FormRequest
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
            'name' => 'required|unique:universities,name',
            'email' => 'required|email|unique:universities,email',
            'logo' => 'required|image|mimes:jpg,jpeg,png,gif|max:2048',
            'phone' => 'required|string|regex:/^[0-9]{10,11}$/',
            'url' => 'required|url',
            'majors' => 'required',
            'address' => 'required|string',
            'description' => 'nullable|string',
        ];
    }

    /**
     * Get the custom validation messages for the request.
     */
    public function messages()
    {
        return [
            'name.required' => 'Tên trường không được để trống.',
            'name.unique' => 'Tên trường này đã tồn tại trong hệ thống.',

            'email.required' => 'Email không được để trống.',
            'email.email' => 'Email phải hợp lệ.',
            'email.unique' => 'Email đã tồn tại trong hệ thống.',

            'logo.required' => 'Logo không được để trống.',
            'logo.image' => 'Logo phải là một hình ảnh.',
            'logo.mimes' => 'Logo phải có định dạng jpg, jpeg, png, hoặc gif.',
            'logo.max' => 'Logo không được vượt quá 2MB.',

            'phone.required' => 'Số điện thoại không được để trống.',
            'phone.regex' => 'Số điện thoại không hợp lệ.',

            'majors.required' => "Chuyên ngành không được để trống",

            'url.require' => 'Địa chỉ URL không được để trống.',
            'url.url' => 'Địa chỉ URL không hợp lệ.',

            'address.required' => 'Địa chỉ không được để trống.',
            'address.string' => 'Địa chỉ phải là chuỗi.',
            'description.string' => 'Mô tả phải là chuỗi.',
        ];
    }
}
