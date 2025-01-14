<?php

namespace App\Http\Controllers\Enterprise;

use App\Exports\Enterprise\DashboardExport;
use App\Http\Controllers\Controller;
use App\Repositories\Enterprises\Dashboard\DashboardRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class DashboardController extends Controller
{
    public function __construct(protected DashboardRepositoryInterface $repository) {}

    public function index()
    {
        [$countJob, $unJob, $percentCountJob, $todayCountJob, $UnPercentCountJob]
            = $this->repository->getJob();

        [$applySuccess, $percentApplySuccess, $todayApplySuccess]
            = $this->repository->getJobApply();

        [$cooperateSuccess, $unCooperate, $percentCooperateSuccess, $todayCooperateSuccess, $unPercentCooperate]
            = $this->repository->getCooperate();

        [$workshopSuccess, $percentWorkshopSuccess, $todayWorkshopSuccess]
            = $this->repository->getWorkshop();

        $featuredJob = $this->repository->getFeaturedJob(perPage: 5);

        [$jobTotalMonth, $cooperateMonth, $jobApplyMonth, $workshopCount]
            = $this->repository->getMonth();

        return view(
            'enterprise.dashboard',
            [
                'applySuccess'              => $applySuccess,
                'cooperateSuccess'          => $cooperateSuccess,
                'unCooperate'               => $unCooperate,
                'workshopSuccess'           => $workshopSuccess,
                'countJob'                  => $countJob,
                'unJob'                     => $unJob,
                'percentCountJob'           => $percentCountJob,
                'UnPercentCountJob'         => $UnPercentCountJob,
                'percentApplySuccess'       => $percentApplySuccess,
                'percentCooperateSuccess'   => $percentCooperateSuccess,
                'unPercentCooperate'        => $unPercentCooperate,
                'percentWorkshopSuccess'    => $percentWorkshopSuccess,
                'featuredJob'               => $featuredJob,
                'todayCountJob'             => $todayCountJob,
                'todayApplySuccess'         => $todayApplySuccess,
                'todayCooperateSuccess'     => $todayCooperateSuccess,
                'todayWorkshopSuccess'      => $todayWorkshopSuccess,
                'jobTotalMonth'             => $jobTotalMonth,
                'cooperateMonth'            => $cooperateMonth,
                'jobApplyMonth'             => $jobApplyMonth,
                'workshopCount'             => $workshopCount,
            ]
        );
    }

    public function dateDashboard(Request $request)
    {
        $startDate = Carbon::parse($request->input('startDateFormatted'))->startOfDay();
        $endDate = Carbon::parse($request->input('endDateFormatted'))->endOfDay();

        [$jobCount, $cooperateCount, $jobApllyCount, $workshopCount] =
            $this->repository->getDateDashboard($startDate, $endDate);

        return response()->json([
            'countJob' => $jobCount,
            'countCooperate' => $cooperateCount,
            'countApply' => $jobApllyCount,
            'countWorkshop' => $workshopCount,
        ]);
    }

    public function exportJob()
    {
        return Excel::download(new DashboardExport($this->repository->getFeaturedJob(perPage: null)), 'featured_job.xlsx');
    }
}
