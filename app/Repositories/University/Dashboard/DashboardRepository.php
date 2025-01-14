<?php

namespace App\Repositories\University\Dashboard;

use App\Models\Workshop;
use App\Repositories\BaseRepository;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class DashboardRepository extends BaseRepository implements DashboardRepositoryInterface
{
    public function getModel()
    {
        return Workshop::class;
    }


    /**
     * @return [Returns the business information of the currently logged in account.]
     */
    public function university()
    {
        return Auth::user()->university;
    }


    /**
     * Get data related to total jobs
     * @return [Returns the variables needed to render the view.]
     */
    public function getWorkshop()
    {
        $workshops = $this->university()->workshops();

        $totalCountWorkshop = (clone $workshops)->count();
        $countWorkshop = (clone $workshops)->where('status', SUCCESS)->count();

        $unWorkshop = $totalCountWorkshop - $countWorkshop;

        if ($countWorkshop != 0) {
            $percentCountWorkshop = round(($countWorkshop / $totalCountWorkshop) * 100);
        } else {
            $percentCountWorkshop = 0;
        }

        $todayCountWorkshop = (clone $workshops)->where('status', SUCCESS)
            ->whereDate('created_at', Carbon::now())->count();
        
        return [$countWorkshop, $unWorkshop, $percentCountWorkshop, $todayCountWorkshop];
    }


    // /**
    //  * Get data related to total jobs apply
    //  * @return [Returns the variables needed to render the view.]
    //  */
    public function getWorkshopApply()
    {
        $workshops = $this->university()->workshops()->with('enterprises')->get();

        $applySuccess = 0;
        $countWorkshopApply = 0;
        $todayApplySuccess = 0;

        foreach ($workshops as $item) {

            $enterprise = $item->enterprises();

            $applySuccess += (clone $enterprise)->where('status', SUCCESS)->count();
            $countWorkshopApply += (clone $enterprise)->count();

            $todayApplySuccess += (clone $enterprise)
                ->where('status', SUCCESS)
                ->whereDate('workshop_enterprise.created_at', Carbon::now())
                ->count();
        }

        if ($applySuccess != 0) {
            $percentApplySuccess = round(($applySuccess / $countWorkshopApply) * 100);
        } else {
            $percentApplySuccess = 0;
        }
        
        return [$applySuccess, $percentApplySuccess, $todayApplySuccess];
    }


    // /**
    //  * Get data related to cooperate
    //  * @return [Returns the variables needed to render the view.]
    //  */
    public function getCooperate()
    {
        $enterprise = $this->university()->enterprises();

        $countCooperate = (clone $enterprise)->count();
        $cooperateSuccess = (clone $enterprise)->where('status', SUCCESS)->count();

        $unCooperate = $countCooperate - $cooperateSuccess;

        if ($cooperateSuccess != 0) {
            $percentCooperateSuccess = round(($cooperateSuccess / $countCooperate) * 100);
        } else {
            $percentCooperateSuccess = 0;
        }

        $todayCooperateSuccess = (clone $enterprise)
            ->where('status', SUCCESS)
            ->whereDate('collaborations.created_at', Carbon::now())
            ->count();

        return [$cooperateSuccess, $unCooperate, $percentCooperateSuccess, $todayCooperateSuccess];
    }


    /**
     * Get data related to workshop
     * @return [Returns the variables needed to render the view.]
     */
    public function getJobUniversity()
    {
        $jobs = $this->university()->jobs();

        $countJob = (clone $jobs)->count();
        $JobSuccess = (clone $jobs)->where('job_university.status', SUCCESS)->count();

        if ($JobSuccess != 0) {
            $percentJobSuccess = round(($JobSuccess / $countJob) * 100);
        } else {
            $percentJobSuccess = 0;
        }

        $todayJObSuccess = (clone $jobs)
            ->where('job_university.status', SUCCESS)
            ->whereDate('job_university.created_at', Carbon::now())
            ->count();

        return [$JobSuccess, $percentJobSuccess, $todayJObSuccess];
    }


    /**
     * Get a list of jobs with the most applications
     * @return [Workshop]
     */
    public function getFeaturedWorkshop($perPage)
    {
        return Workshop::where('university_id', $this->university()->id)
            ->withCount('enterprises')
            ->orderBy('enterprises_count', 'desc')
            ->paginate($perPage);
    }


    public function getDateDashboard($startDate, $endDate)
    {
        $university = $this->university();
        $date = [$startDate, $endDate];

        $workshopCount = $university->workshops()
            ->where('status', SUCCESS)
            ->whereBetween('created_at', $date)
            ->count();

        $cooperateCount = $university->universities()
            ->where('status', SUCCESS)
            ->whereBetween('collaborations.created_at', $date)
            ->count();

        $workshopApplyCount = 0;
        foreach ($university->workshops as $item) {
            $workshopApplyCount += $item->enterprises()
                ->where('status', SUCCESS)
                ->whereBetween('workshop_enterprise.created_at', $date)
                ->count();
        }

        $jobCount = $university->jobs()
            ->where('job_university.status', SUCCESS)
            ->whereBetween('job_university.created_at', $date)
            ->count();
        dd($workshopCount, $cooperateCount, $workshopApplyCount, $jobCount);
        return [$workshopCount, $cooperateCount, $workshopApplyCount, $jobCount];
    }


    public function getMonth()
    {
        $university = $this->university();

        $workshopTotalMonth = [];
        $cooperateMonth = [];
        $workshopApplyMonth = [];
        $JobCount = [];

        for ($month = 1; $month <= 12; $month++) {
            $workshopTotalMonth[] = $university->workshops()
                ->where('status', SUCCESS)
                ->whereMonth('created_at', $month)
                ->count();

            $cooperateMonth[] = $university->enterprises()
                ->where('status', SUCCESS)
                ->whereMonth('collaborations.created_at', $month)
                ->count();

            $workshopApplyMonth[] = $university->workshops()
                ->whereHas('enterprises', function ($query) use ($month) {
                    $query->where('status', SUCCESS)
                        ->whereMonth('workshop_enterprise.created_at', $month);
                })->count();

            $JobCount[] = $university->jobs()
                ->where('job_university.status', SUCCESS)
                ->whereMonth('job_university.created_at', $month)
                ->count();
        }

        return [$workshopTotalMonth, $cooperateMonth, $workshopApplyMonth, $JobCount];
    }
}
