<?php

namespace App\Repositories\Enterprises\Dashboard;

use App\Models\Job;
use App\Repositories\BaseRepository;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class DashboardRepository extends BaseRepository implements DashboardRepositoryInterface
{
    public function getModel()
    {
        return Job::class;
    }


    /**
     * @return [Returns the business information of the currently logged in account.]
     */
    public function enterprise()
    {
        return Auth::user()->enterprise;
    }


    /**
     * Get data related to total jobs
     * @return [Returns the variables needed to render the view.]
     */
    public function getJob()
    {
        $jobs = $this->enterprise()->jobs();

        $totalCountJob = (clone $jobs)->count();
        $countJob = (clone $jobs)->where('status', APPROVED)->count();

        $unJob = (clone $jobs)->where('status', UN_APPROVE)->count();

        if ($countJob != 0) {
            $percentCountJob = round(($countJob / $totalCountJob) * 100);
            $UnPercentCountJob = round(($unJob / $totalCountJob) * 100);
        } else {
            $percentCountJob = 0;
            $UnPercentCountJob = 0;
        }

        $todayCountJob = (clone $jobs)->where('status', SUCCESS)
            ->whereDate('created_at', Carbon::now())->count();

        return [$countJob, $unJob, $percentCountJob, $todayCountJob, $UnPercentCountJob];
    }


    /**
     * Get data related to total jobs apply
     * @return [Returns the variables needed to render the view.]
     */
    public function getJobApply()
    {
        $jobs = $this->enterprise()->jobs;

        $applySuccess = 0;
        $countJobAplly = 0;
        $todayApplySuccess = 0;

        foreach ($jobs as $item) {
            $university = $item->universities();

            $applySuccess += (clone $university)->where('status', SUCCESS)->count();
            $countJobAplly += (clone $university)->count();

            $todayApplySuccess += (clone $university)
                ->where('status', SUCCESS)
                ->whereDate('job_university.created_at', Carbon::now())
                ->count();
        }

        if ($applySuccess != 0) {
            $percentApplySuccess = round(($applySuccess / $countJobAplly) * 100);
        } else {
            $percentApplySuccess = 0;
        }

        return [$applySuccess, $percentApplySuccess, $todayApplySuccess];
    }


    /**
     * Get data related to cooperate
     * @return [Returns the variables needed to render the view.]
     */
    public function getCooperate()
    {
        $universities = $this->enterprise()->universities();

        $countCooperate = (clone $universities)->count();
        $cooperateSuccess = (clone $universities)->where('status', APPROVED)->count();

        $unCooperate = (clone $universities)->where('status', UN_APPROVE)->count();

        if ($cooperateSuccess != 0) {
            $percentCooperateSuccess = round(($cooperateSuccess / $countCooperate) * 100);
            $unPercentCooperate = round(($unCooperate / $countCooperate) * 100);
        } else {
            $percentCooperateSuccess = 0;
            $unPercentCooperate = 0;
        }

        $todayCooperateSuccess = (clone $universities)
            ->where('status', SUCCESS)
            ->whereDate('collaborations.created_at', Carbon::now())
            ->count();

        return [$cooperateSuccess, $unCooperate, $percentCooperateSuccess, $todayCooperateSuccess, $unPercentCooperate];
    }


    /**
     * Get data related to workshop
     * @return [Returns the variables needed to render the view.]
     */
    public function getWorkshop()
    {
        $workshop = $this->enterprise()->workshops();

        $countWorkshop = (clone $workshop)->count();
        $workshopSuccess = (clone $workshop)->where('workshop_enterprise.status', SUCCESS)->count();

        if ($workshopSuccess != 0) {
            $percentWorkshopSuccess = round(($workshopSuccess / $countWorkshop) * 100);
        } else {
            $percentWorkshopSuccess = 0;
        }

        $todayWorkshopSuccess = (clone $workshop)
            ->where('workshop_enterprise.status', SUCCESS)
            ->whereDate('workshop_enterprise.created_at', Carbon::now())
            ->count();

        return [$workshopSuccess, $percentWorkshopSuccess, $todayWorkshopSuccess];
    }


    /**
     * Get a list of jobs with the most applications
     * @return [Job]
     */
    public function getFeaturedJob($perPage)
    {
        return Job::where('enterprise_id', $this->enterprise()->id)
            ->withCount('universities')
            ->orderBy('universities_count', 'desc')
            ->paginate($perPage);
    }


    public function getDateDashboard($startDate, $endDate)
    {
        $enterprise = $this->enterprise();
        $date = [$startDate, $endDate];

        $jobCount = $enterprise->jobs()
            ->where('status', SUCCESS)
            ->whereBetween('created_at', $date)
            ->count();

        $cooperateCount = $enterprise->universities()
            ->where('status', SUCCESS)
            ->whereBetween('collaborations.created_at', $date)
            ->count();

        $jobApllyCount = 0;
        foreach ($enterprise->jobs as $item) {
            $jobApllyCount += $item->universities()
                ->where('status', SUCCESS)
                ->whereBetween('job_university.created_at', $date)
                ->count();
        }

        $workshopCount = $enterprise->workshops()
            ->where('workshop_enterprise.status', SUCCESS)
            ->whereBetween('workshop_enterprise.created_at', $date)
            ->count();

        return [$jobCount, $cooperateCount, $jobApllyCount, $workshopCount];
    }


    public function getMonth()
    {
        $enterprise = $this->enterprise();

        $jobTotalMonth = [];
        $cooperateMonth = [];
        $jobApplyMonth = [];
        $workshopCount = [];

        for ($month = 1; $month <= 12; $month++) {
            $jobTotalMonth[] = $enterprise->jobs()
                ->where('status', SUCCESS)
                ->whereMonth('created_at', $month)
                ->count();

            $cooperateMonth[] = $enterprise->universities()
                ->where('status', SUCCESS)
                ->whereMonth('collaborations.created_at', $month)
                ->count();

            $jobApplyMonth[] = $enterprise->jobs()
                ->whereHas('universities', function ($query) use ($month) {
                    $query->where('status', SUCCESS)
                        ->whereMonth('job_university.created_at', $month);
                })->count();

            $workshopCount[] = $enterprise->workshops()
                ->where('workshop_enterprise.status', SUCCESS)
                ->whereMonth('workshop_enterprise.created_at', $month)
                ->count();
        }

        return [$jobTotalMonth, $cooperateMonth, $jobApplyMonth, $workshopCount];
    }
}
