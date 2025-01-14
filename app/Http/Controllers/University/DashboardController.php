<?php

namespace App\Http\Controllers\University;

use App\Exports\Enterprise\DashboardExport;
use App\Http\Controllers\Controller;
use App\Repositories\University\Dashboard\DashboardRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class DashboardController extends Controller
{
    public function __construct(protected DashboardRepositoryInterface $repository) {}

    public function index()
    {
        [$countWorkshop, $unWorkshop, $percentCountWorkshop, $todayCountWorkshop]
            = $this->repository->getWorkshop();

        [$applySuccess, $percentApplySuccess, $todayApplySuccess]
            = $this->repository->getWorkshopApply();

        [$cooperateSuccess, $unCooperate, $percentCooperateSuccess, $todayCooperateSuccess]
            = $this->repository->getCooperate();

        [$jobSuccess, $percentJobSuccess, $todayJobSuccess]
            = $this->repository->getJobUniversity();

        $featuredWorkshop = $this->repository->getFeaturedWorkshop(perPage: 5);

        [$workshopTotalMonth, $cooperateMonth, $workshopApplyMonth, $jobTotalMonth]
            = $this->repository->getMonth();

        return view(
            'university.dashboard',
            [

                'countWorkshop'             => $countWorkshop,
                'unWorkshop'                => $unWorkshop,
                'percentCountWorkshop'      => $percentCountWorkshop,
                'todayCountWorkshop'        => $todayCountWorkshop,

                'applySuccess'              => $applySuccess,
                'percentApplySuccess'       => $percentApplySuccess,
                'todayApplySuccess'         => $todayApplySuccess,

                'cooperateSuccess'          => $cooperateSuccess,
                'unCooperate'               => $unCooperate,
                'percentCooperateSuccess'   => $percentCooperateSuccess,
                'todayCooperateSuccess'     => $todayCooperateSuccess,

                'jobSuccess'                => $jobSuccess,
                'percentJobSuccess'         => $percentJobSuccess,
                'todayJobSuccess'           => $todayJobSuccess,

                'featuredWorkshop'               => $featuredWorkshop,

                'workshopTotalMonth'        => $workshopTotalMonth,
                'cooperateMonth'            => $cooperateMonth,
                'workshopApplyMonth'        => $workshopApplyMonth,
                'jobTotalMonth'             => $jobTotalMonth,
            ]
        );
    }


    public function dateDashboard(Request $request)
    {
        $startDate = Carbon::parse($request->input('startDateFormatted'))->startOfDay();
        $endDate = Carbon::parse($request->input('endDateFormatted'))->endOfDay();

        [$workshopCount, $cooperateCount, $workshopApplyCount, $jobCount] =
            $this->repository->getDateDashboard($startDate, $endDate);

        return response()->json([
            'countWorkshop' => $workshopCount,
            'countCooperate' => $cooperateCount,
            'countApply' => $workshopApplyCount,
            'countJob' => $jobCount,
        ]);
    }

    public function exportWorkshop()
    {
        return Excel::download(new DashboardExport($this->repository->getFeaturedWorkshop(perPage: null)), 'featured_workshop.xlsx');
    }
}
