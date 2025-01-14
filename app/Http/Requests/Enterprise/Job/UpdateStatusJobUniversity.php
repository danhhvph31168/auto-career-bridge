<?php

namespace App\Http\Requests\Enterprise\Job;

use Illuminate\Foundation\Http\FormRequest;

class UpdateStatusJobUniversity  extends FormRequest
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
            'status' => 'required|in:' . APPROVED . ',' . UN_APPROVE,
        ];
    }
    public function messages()
    {
        return [
            'status.required' => 'Status không được để trống.',
            'status.in' => 'Status không tồn tại.',
        ];
    }
}
