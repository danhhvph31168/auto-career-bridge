<?php

namespace App\Http\Requests\Enterprise\Job;

use Illuminate\Foundation\Http\FormRequest;

class UpdateManyStatusJobRequest  extends FormRequest
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
            'job_ids' => 'required|array',
            'job_ids.*' => 'exists:jobs,id',
            'is_active' => 'required|in:' . IS_ACTIVE . ',' . UN_ACTIVE,
        ];
    }
    public function messages()
    {
        return [
            'job_ids.required' => 'job_ids không được để trống.',
            'job_ids.array' => 'job_ids phải là mảng.',
            'job_ids.*.exists' => 'job_id không tồn tại.',

            'is_active.required' => 'Is_active không được để trống.',
            'is_active.in' => 'Is_active không tồn tại.',
        ];
    }
}
