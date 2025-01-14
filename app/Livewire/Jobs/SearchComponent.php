<?php

namespace App\Livewire\Jobs;

use App\Models\Major;
use App\Repositories\Major\MajorRepository;
use Livewire\Component;

class SearchComponent extends Component
{

    public $keyword = '';
    public $province = '';
    public $major = '';
    public $perpage = 5;
    public $type = '';
    public $experience_level = '';
    public $salary = '';
    public $data = [];
    public $listeners = ['updatedMajor', 'updatedPerpage', 'updatedProvince', 'dataFilter'];

    public function mount()
    {
        $this->keyword = request()->input('keyword');
        $this->province = request()->input('province');
    }

    public function updatedProvince($province)
    {
        $this->province = $province;
        $this->getDataSearch();
    }
    public function dataFilter($data)
    {
        $this->type = $data['type'];
        $this->experience_level = $data['experience_level'];
        $this->salary = $data['salary'];
        $this->getDataSearch();
    }

    public function updatedMajor($major)
    {
        $this->major = $major;
        $this->getDataSearch();
    }

    public function updatedPerpage($perpage)
    {
        $this->perpage = $perpage;
        $this->getDataSearch();
    }

    public function getDataSearch()
    {
        $this->dispatch('dataSearch', $this->data = [
            'keyword' => $this->keyword,
            'province' => $this->province,
            'major' => $this->major,
            'perpage' => $this->perpage,
            'type' => $this->type,
            'salary' => $this->salary,
            'experience_level' => $this->experience_level
        ]);
    }

    public function render(MajorRepository $majorRepository)
    {
        $majors = $majorRepository->getAll();

        return view('livewire.jobs.search-component', [
            'majors' => $majors
        ]);
    }
}
