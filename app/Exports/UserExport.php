<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Cell\DataValidation;
use App\Services\University\UserService;

class UserExport implements FromCollection, WithHeadings, WithEvents
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    // Define tile
    public $styleHeader = [
        'alignment' => [
            'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
            'wrapText' => true,
        ],
        'fill' => [
            'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
            'startColor' => ['argb' => 'ededed'],
        ],
        'font' => [
            'size' => 14,
            'bold' => true,
            'name' => 'Times New Roman',
        ],
        'borders' => [
            'outline' => [
                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                'color' => ['argb' => '000000'],
            ],
        ],
    ];

    // Define style
    public $styleCell = [
        'alignment' => [
            'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
            'wrapText' => true,
        ],
        'font' => [
            'size' => 13,
            'name' => 'Times New Roman',
        ],
        'borders' => [
            'allBorders' => [
                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                'color' => ['argb' => '000000'],
            ],
        ],
    ];

    // Sample data
    public function collection()
    {
        $outputArr = [];
        $universities = $this->userService->getAll(); 
        foreach($universities as $key => $value) {
            array_push($outputArr, [
                $key + 1,
                $value->username,
                $value->email,
                $value->password,
                $value->avatar,
                $value->phone,
                $value->university->name,
                $value->role->name,
            ]);
        }
        return collect($outputArr);
    }

    // Title
    public function headings(): array
    {
        return [
            "STT",
            "Họ và tên",
            "Email",
            "Số điện thoại",
            "Mật khẩu",
            "Địa chỉ",
            "Đại học",
            "Vai trò",
        ];
    }

    /**
     * Event edit after creating sheet
     * 
     * @return array
     */
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();

                $sheet->getStyle("A1:H1")->applyFromArray($this->styleHeader);

                $columns = ['A' => 5, 'B' => 20, 'C' => 25, 'D' => 20, 'E' => 15, 'F' => 25, 'G' => 15, 'H' => 25];
                foreach ($columns as $col => $width) {
                    $sheet->getColumnDimension($col)->setWidth($width);
                }

                $lastRow = 11;
                $sheet->getStyle("A2:H$lastRow")->applyFromArray($this->styleCell);

                for ($row = 2; $row <= $lastRow; $row++) {
                    $validation = $sheet->getCell("G$row")->getDataValidation();
                    $validation->setType(DataValidation::TYPE_LIST);
                    $validation->setErrorStyle(DataValidation::STYLE_STOP);
                    $validation->setAllowBlank(false);
                    $validation->setShowDropDown(true);
                    $validation->setFormula1('"Admin,Giáo vụ"');
                    $validation->setErrorTitle('Lỗi nhập liệu');
                    $validation->setError('Giá trị không nằm trong danh sách.');
                    $validation->setPromptTitle('Chọn vai trò');
                    $validation->setPrompt('Vui lòng chọn giá trị từ danh sách.');
                }
            },
        ];
    }
}
