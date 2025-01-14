<?php

namespace App\Livewire\Admin\University;

use App\Services\Admin\UniversityService;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Livewire\WithPagination;

class UserListComponent extends Component
{
    use WithPagination;

    public $keyword = '';
    public $perpage = 5;
    public $status = '';
    public $condition = [];
    public $listeners = ['deleteAccount'];

    public function deleteAccount(UniversityService $universityService, $id)
    {
        $status = $universityService->destroy($id);
        $this->dispatch('accountDeleted', $status);
    }

    public function getDataSearch()
    {
        $this->condition = [
            'keyword' => $this->keyword,
            'perpage' => $this->perpage,
            'status' => $this->status,
        ];
        $this->resetPage();
    }

    public function render(UniversityService $universityService)
    {
        $users = $universityService->getUniversityAccount($this->condition);

        return view('admin.universities.users.partials.list', [
            'users' => $users,
            'config' => config('admin.university.approve')
        ]);
    }
}
