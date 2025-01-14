<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Job;
use App\Repositories\Job\JobRepositoryInterface;
use App\Repositories\Major\MajorRepositoryInterface;
use App\Repositories\Notification\NotificationRepository;
use App\Services\Client\JobService;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class JobController extends Controller
{
    const PATH_CLIENT_VIEW = 'client.jobs.index';
    protected $jobRepository;
    protected $jobService;
    protected $majorRepository;
    protected $notificationRepository;

    public function __construct(
        JobRepositoryInterface $jobRepository,
        MajorRepositoryInterface $majorRepository,
        JobService $jobService,
        NotificationRepository $notificationRepository,
    ) {
        $this->jobRepository = $jobRepository;
        $this->majorRepository = $majorRepository;
        $this->jobService = $jobService;
        $this->notificationRepository = $notificationRepository;
    }

    public function index()
    {
        $config = config('apps.clients');

        return view(self::PATH_CLIENT_VIEW, [
            'config' => $config
        ]);
    }

    /**
     * Undocumented function
     *
     * @param int $id
     * @return [view]
     */
    public function detail($id)
    {
        $job = $this->jobRepository->findById($id);
        if (!isset($job) && empty($job)) {

            return abort(404);
        }
        $config = config('apps.clients');
        $enterprise = $job->enterprises;

        if (!empty(Auth::user()->university)) {
            $checkApply = $this->jobRepository->checkApplyExists(Auth::user()->university, $job->id);
            $checkApplySuccess = $this->jobRepository->checkApplySuccess(Auth::user()->university, $job->id);
            $checkApplyRefuse = $this->jobRepository->checkApplyRefuse(Auth::user()->university, $job->id);
        } else {
            $checkApply = false;
            $checkApplySuccess = false;
            $checkApplyRefuse = false;
        }

        return view(self::PATH_CLIENT_VIEW, [
            'job' => $job,
            'enterprise' => $enterprise,
            'config' => $config,
            'checkApply' => $checkApply,
            'checkApplySuccess' => $checkApplySuccess,
            'checkApplyRefuse' => $checkApplyRefuse,
        ]);
    }

    public function apply()
    {
        $result = $this->jobService->apply();

        return back()->with($result['status'], $result['message']);
    }
}
