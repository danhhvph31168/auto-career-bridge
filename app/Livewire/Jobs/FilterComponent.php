<?php

namespace App\Livewire\Jobs;

use Livewire\Component;

class FilterComponent extends Component
{

    public $type = '';
    public $experience_level = '';
    public $salary = '0 ₫ - 99.999.999 ₫';
    public $data = [];

    public $listeners = ['updatedSalary'];

    public function updatedSalary($salary)
    {
        $this->salary = $salary;
        $this->sendDataToSearchComponent();
    }

    public function sendDataToSearchComponent()
    {
        $this->dispatch('dataFilter', $this->data = [
            'type' => $this->type,
            'salary' => $this->salary,
            'experience_level' => $this->experience_level
        ]);
    }

    public function render()
    {
        return view('livewire.jobs.filter-component');
    }
}
