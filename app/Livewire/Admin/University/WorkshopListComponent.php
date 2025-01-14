<?php

namespace App\Livewire\Admin\University;

use App\Services\Admin\WorkshopService;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Livewire\WithPagination;

class WorkshopListComponent extends Component
{
    use WithPagination;

    public $title = '';
    public $perpage = 5;
    public $status = '';
    public $start_date = '';
    public $end_date = '';
    public $condition = [];
    public $listeners = ['deleteWorkshop'];
    public $page = '';

    public function mount()
    {
        $this->condition = [
            'page' => 'system-admin'
        ];
    }

    public function deleteWorkshop(WorkshopService $workshopService, $id)
    {
        $status = $workshopService->destroy($id);
        $this->dispatch('workshopDeleted', $status);
    }

    public function getDataSearch()
    {

        $this->condition = [
            'title' => $this->title,
            'perpage' => $this->perpage,
            'status' => $this->status,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'page' => 'system-admin'
        ];
        $this->resetPage();
    }

    public function render(WorkshopService $workshopService)
    {
        $workshops = $workshopService->getWorkshop($this->condition);

        return view('admin.universities.workshops.partials.list', [
            'workshops' => $workshops,
            'config' => config('admin.workshop')
        ]);
    }
}
