<?php

namespace App\Exports;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class UsersExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return User::select(['username', 'email', 'phone', 'created_at'])
            ->where('enterprise_id', Auth::user()?->enterprise_id ?? abort(403))
            ->where('role_id', config('constants.enterprise.role.user.id'))
            ->get();
    }

    public function headings(): array
    {
        return [
            'Họ và Tên',
            'Email',
            'Số điện thoại',
            'Ngày tạo',
        ];
    }
}
