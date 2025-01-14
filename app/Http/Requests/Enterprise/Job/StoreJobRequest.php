<?php

namespace App\Http\Requests\Enterprise\Job;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

class StoreJobRequest extends FormRequest
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
            'major_id' => 'required|exists:majors,id',
            'title' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'requirement' => 'required|string|max:255',
            'working_time' => 'required|string|max:50',
            'experience_level' => 'required|in:' . NO_EXPERIENCE . ',' . ONE_YEAR . ',' . TWO_YEAR,
            'benefit' => 'required|string|max:255',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after_or_equal:date',
            'salary' => 'required|numeric|regex:/^\d{1,8}(\.\d{1,2})?$/',
            'description' => 'required|string|max:5000',
            'type' => 'required|in:' . PART_TIME . ',' . FULL_TIME . ',' . REMOTE,
            'is_active' => 'required|in:' . IS_ACTIVE . ',' . UN_ACTIVE,
        ];
    }
    public function messages()
    {
        return [
            'major_id.required' => 'Chuyên ngành không được để trống.',
            'major_id.exists' => 'Chuyên ngành không tồn tại.',

            'title.required' => 'Tiêu đề không được để trống.',
            'title.string' => 'Tiêu đề phải là chuỗi.',
            'title.max' => 'Tiêu đề không được vượt quá :max ký tự.',

            'address.required' => 'Địa chỉ không được để trống.',
            'address.string' => 'Địa chỉ phải là chuỗi.',
            'address.max' => 'Địa chỉ không được vượt quá :max ký tự.',

            'requirement.required' => 'Yêu cầu không được để trống.',
            'requirement.string' => 'Yêu cầu phải là chuỗi.',
            'requirement.max' => 'Yêu cầu không được vượt quá :max ký tự.',

            'working_time.required' => 'Thời gian làm việc không được để trống.',
            'working_time.string' => 'Thời gian làm việc phải là chuỗi.',
            'working_time.max' => 'Thời gian làm việc không được vượt quá :max ký tự.',

            'experience_level.required' => 'Kinh nghiệm không được để trống.',
            'experience_level.in' => 'Kinh nghiệm không hợp lệ.',

            'benefit.required' => 'Lợi ích không được để trống.',
            'benefit.string' => 'Lợi ích phải là chuỗi.',
            'benefit.max' => 'Lợi ích không được vượt quá :max ký tự.',

            'start_date.required' => 'Ngày bắt đầu không được để trống.',
            'start_date.date' => 'Ngày bắt đầu không hợp lệ.',
            'start_date.after_or_equal' => 'Ngày bắt đầu phải từ hôm nay trở đi',

            'end_date.required' => 'Ngày kết thúc không được để trống.',
            'end_date.date' => 'Ngày kết thúc không hợp lệ.',
            'end_date.after_or_equal' => 'Ngày kết thúc phải sau ngày bắt đầu.',

            'salary.required' => 'Lương không được để trống',
            'salary.numeric' => 'Lương phải là số',
            'salary.regex' => 'Lương tối đa 8 chữ số trước dấu chấm và 2 chữ số sau dấu chấm',

            'description.required' => 'Mô tả không được để trống.',
            'description.string' => 'Mô tả phải là chuỗi.',
            'description.max' => 'Mô tả không được vượt quá 5000 ký tự.',

            'type.required' => 'Cách thực làm việc không được để trống.',
            'type.in' => 'Cách thực làm việc không hợp lệ.',

            'is_active.required' => 'Trạng thái không được để trống.',
            'is_active.in' => 'Trạng thái không hợp lệ.',
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $isActive = $this->input('is_active');
            $startDate = $this->input('start_date');
            $endDate = $this->input('end_date');

            if ($isActive == IS_ACTIVE) {
                $currentDate = Carbon::now();

                if (!$currentDate->between(Carbon::parse($startDate)->startOfDay(), Carbon::parse($endDate)->endOfDay(), true)) {
                    $validator->errors()->add(
                        'is_active',
                        'Chưa tới thời gian bắt đầu, chưa thể để trạng thái là hoạt động'
                    );
                }
            }
        });
    }
}
