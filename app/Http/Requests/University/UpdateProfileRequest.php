<?php

namespace App\Http\Requests\University;

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
            'logo' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
            'majors' => 'required|array',
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
            'logo.image' => 'Logo phải là một hình ảnh.',
            'logo.mimes' => 'Logo phải có định dạng jpg, jpeg, png, hoặc gif.',
            'logo.max' => 'Logo không được vượt quá 2MB.',

            'majors' => 'Chuyên ngành là bắt buộc',

            'address.required' => 'Địa chỉ không được để trống.',
            'address.string' => 'Địa chỉ phải là chuỗi.',
            'description.string' => 'Mô tả phải là chuỗi.',
        ];
    }
}
