<?php

namespace App\Livewire\Workshops;

use App\Repositories\Major\MajorRepository;
use App\Services\Admin\WorkshopService;
use Livewire\Component;
use Livewire\WithPagination;

class WorkshopComponent extends Component
{
    use WithPagination;
    public $keyword = '';
    public $perpage = 5;
    public $province = '';
    public $major = '';
    public $start_date = '';
    public $end_date = '';
    public $data = [];
    public $page = '';
    public $listeners = ['updatedProvince', 'updatedPerpage', 'updatedMajor'];

    public function mount()
    {
        $this->data = [
            'page' => 'client'
        ];
    }

    public function updatedProvince($province)
    {
        $this->province = $province;
        $this->getDataSearch();
    }

    public function updatedPerpage($perpage)
    {
        $this->perpage = $perpage;
        $this->getDataSearch();
    }

    public function updatedMajor($major)
    {
        $this->major = $major;
        $this->getDataSearch();
    }

    public function getDataSearch()
    {
        $this->data = [
            'province' => $this->province,
            'title' => $this->keyword,
            'perpage' => $this->perpage,
            'major' => $this->major,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'page' => 'client'
        ];
    }

    public function render(MajorRepository $majorRepository, WorkshopService $workshopService)
    {
        $majors = $majorRepository->getAll();
        $workshops = $workshopService->getWorkshop($this->data);

        return view('client.workshops.components.list', [
            'majors' => $majors,
            'workshops' => $workshops
        ]);
    }
}
