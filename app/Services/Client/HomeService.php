<?php

namespace App\Services\Client;

use App\Models\Enterprise;
use App\Models\Job;
use App\Models\User;
use App\Repositories\Enterprises\EnterpriseRepositoryInterface;
use App\Repositories\Major\MajorRepositoryInterface;

class HomeService
{

    protected $enterpriseRepositories;
    protected $majorRepositories;

    public function __construct(
        EnterpriseRepositoryInterface $enterpriseRepositories,
        MajorRepositoryInterface $majorRepositories
    ) {
        $this->enterpriseRepositories = $enterpriseRepositories;
        $this->majorRepositories = $majorRepositories;
    }

    public function getJobAndCompanyStats()
    {

        $listEnterprise = $this->enterpriseRepositories->getAll();
        $listMajor = $this->majorRepositories->getAll();

        $totalJobs = Job::count();
        $totalUser = User::count();
        $totalJobsToDay = Job::where('created_at', '=', now())->count();
        $totalEnterprise = Enterprise::count();

        $newJobs = Job::where('created_at', '>=', now()->subMonth())->count();

        $jobList = Job::where('created_at', '>=', now()->subMonth())
              ->where('status', APPROVED)
              ->with('enterprises') 
              ->paginate(4);

        return [
            'totalJobs' => $totalJobs,
            'totalJobsToDay' => $totalJobsToDay,
            'totalEnterprise' => $totalEnterprise,
            'totalUser' => $totalUser,
            'newJobs' => $newJobs,
            'listEnterprise' => $listEnterprise,
            'listMajor' => $listMajor,
            'jobList' => $jobList,
        ];
    }
}
