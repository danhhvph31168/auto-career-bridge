<?php

namespace App\Exports\Enterprise;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;

class DashboardExport implements FromCollection, ShouldAutoSize, WithHeadings
{
    use Exportable;

    public function __construct(protected $dashboard) {}

    public function collection()
    {
        return $this->dashboard->map(function ($item) {
            return [
                'universities_count' => $item->universities_count,
                'title' => $item->title,
                'address' => $item->address,
                'requirement' => $item->requirement,
                'working_time' => $item->working_time,
                'experience_level' => $item->experience_level,
                'benefit' => $item->benefit,
                'start_date' => $item->start_date,
                'end_date' => $item->end_date,
                'applicants' => $item->applicants,
                'salary' => $item->salary,
                'description' => $item->description,
                'type' => $item->type,
                'status' => $item->status,
                'created_at' => $item->created_at->format('d-m-Y'),
            ];
        });
    }

    public function headings(): array
    {
        return [
            "Apply Success",
            "Title",
            "Address",
            "Requirement",
            "Working Time",
            "Experience Level",
            "Benefit",
            "Start Date",
            "End Date",
            "Applicants",
            "Salary",
            "Description",
            "Type",
            "Status",
            "Created At",
        ];
    }
}
