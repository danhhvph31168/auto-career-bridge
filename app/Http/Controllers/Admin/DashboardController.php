<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Client\UniversityService;
use App\Services\EnterpriseService;
use App\Services\JobService;
use App\Services\University\WorkshopService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function __construct(
        protected JobService $jobService,
        protected WorkshopService $workshopService,
        protected UniversityService $universityService,
        protected EnterpriseService $enterpriseService,
    ) {}
    public function index(Request $request)
    {
        $years = DB::table('job_university')
            ->selectRaw('YEAR(created_at) as year')
            ->union(
                DB::table('workshop_enterprise')
                    ->selectRaw('YEAR(created_at) as year')
            )
            ->distinct()
            ->orderBy('year')
            ->pluck('year');

        $yearNow = request('year', now()->year);

        if (!is_numeric($yearNow) || $yearNow < 1900 || $yearNow > now()->year) {
            $yearNow = now()->year;
        }

        $dashboardJob = $this->jobService->getDashboardData($yearNow);

        $dashboardWorkshop = $this->workshopService->getDashboardData($yearNow);

        if ($request->wantsJson()) {
            return response()->json(['data' => [
                'dashboardJob' => $dashboardJob,
                'dashboardWorkshop' => $dashboardWorkshop,
            ]]);
        }

        $dashboardUniversity = $this->universityService->getDashboardData();

        $dashboardEnterprise = $this->enterpriseService->getDashboardData();

        return view(
            'admin.dashboard',
            compact(
                'years',
                'dashboardJob',
                'dashboardWorkshop',
                'dashboardUniversity',
                'dashboardEnterprise',
            )
        );
    }
}
