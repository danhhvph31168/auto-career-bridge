<?php

namespace App\Livewire\Admin\University;

use App\Services\Admin\MajorService;
use Livewire\Component;
use Livewire\WithPagination;

class MajorListComponent extends Component
{
    use WithPagination;

    public $keyword = '';
    public $perpage = 5;
    public $status = '';
    public $listeners = ['deleteMajor'];

    public function deleteMajor($id, MajorService $majorService)
    {
        $status = $majorService->destroy($id);
        $this->dispatch('majorDeleted', $status);
    }


    public function render(MajorService $majorService)
    {
        $config = config('admin.major');
        $condition = [
            'keyword' => $this->keyword,
            'perpage' => $this->perpage,
            'status' => $this->status,
            'page' => 'system-admin'
        ];
        $majors = $majorService->getMajorApprove($condition);

        return view('admin.majors.list-component', [
            'config' => $config,
            'majors' => $majors,
        ]);
    }
}
