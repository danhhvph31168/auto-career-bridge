<?php

namespace App\Livewire\Jobs;

use Livewire\Component;
use App\Services\Client\JobService;
use Livewire\WithPagination;

class ListComponent extends Component
{
    use WithPagination;

    public $listeners = ['dataSearch'];

    public $data = [];

    public function dataSearch($data)
    {
        $this->data = $data;
        $this->resetPage();
    }

    public function render(JobService $jobService)
    {
        $jobs = $jobService->pagination($this->data);

        return view('livewire.jobs.list-component', [
            'jobs' => $jobs
        ]);
    }
}
