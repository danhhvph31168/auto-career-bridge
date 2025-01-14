<?php

namespace App\Http\Controllers\Enterprise;

use App\Http\Controllers\Controller;
use App\Http\Requests\Enterprise\Job\StoreJobRequest;
use App\Http\Requests\Enterprise\Job\UpdateJobRequest;
use App\Http\Requests\Enterprise\Job\UpdateManyStatusJobRequest;
use App\Http\Requests\Enterprise\Job\UpdateStatusJobUniversity;
use App\Models\Job;
use App\Models\Major;
use App\Models\University;
use App\Services\Enterprise\JobService;
use App\Services\MajorService;
use Illuminate\Http\Request;

class JobController extends Controller
{
    const PATH_VIEW = 'enterprise.job.';
    public function __construct(
        protected JobService $jobService,
        protected MajorService $majorService,
    ) {}

    public function index(Request $request)
    {
        $perPage = $request->perPage ?? 10;

        $search = [
            'keyword' => $request->get('keyword', ''),
            'start_date' => $request->get('start_date', ''),
            'end_date' => $request->get('end_date', ''),
        ];

        $jobs = $this->jobService->getAllJobs($perPage, $search);

        return view(self::PATH_VIEW . __FUNCTION__, compact('jobs'));
    }

    public function create()
    {
        $majors = $this->majorService->getAllMajors();

        return view(self::PATH_VIEW . __FUNCTION__, compact('majors'));
    }

    public function store(StoreJobRequest $request)
    {
        $this->jobService->createJob($request->all());

        return redirect()->route('enterprise.jobs.index')->with('success', 'Thêm job thành công');
    }

    public function edit(Job $job)
    {
        $majors = $this->majorService->getAllMajors();

        return view(self::PATH_VIEW . __FUNCTION__, compact('job', 'majors'));
    }

    public function update(UpdateJobRequest $request, Job $job)
    {
        $result = $this->jobService->updateJob($job->id, $request->all());

        if (!$result) return back()->with('error', 'Cập nhật công việc thất bại');

        return redirect()->route('enterprise.jobs.index')->with('success', 'Cập nhật công việc thành công');
    }

    public function updateManyStatus(UpdateManyStatusJobRequest $request)
    {
        $result = $this->jobService->updateManyStatusJobs($request->all());

        if (!empty($result['id_invalid']) && $result['update']) {
            return response()->json([
                'type' => 'warning',
                'message' => 'Cập nhật trạng thái thành công, nhưng có một số công việc chưa tới ngày bắt đầu hoặc đã quá hạn',
                'id_invalid' => $result['id_invalid'],
            ]);
        }

        if (!empty($result['id_invalid'])) {
            return response()->json([
                'type' => 'error',
                'message' => 'Cập nhật trạng thái thất bại, do chưa tới ngày bắt đầu hoặc đã quá hạn',
                'id_invalid' => $result['id_invalid'],
            ]);
        }

        return response()->json(['data' => ['message' => 'Cập nhật trạng thái thành công',]]);
    }

    public function show(Request $request, Job $job)
    {
        $majors = $this->majorService->getAllMajors();

        $job->load('major', 'universities');

        $name = $request->get('name', '');

        $universities = $job->universities();

        if ($name) {
            $universities = $universities->where('name', 'LIKE', '%' . $name . '%');
        }

        $universities = $universities->paginate(5)->withQueryString();

        return view(self::PATH_VIEW . __FUNCTION__, compact('job', 'majors', 'universities'));
    }

    public function destroy(int $id)
    {
        $result = $this->jobService->destroyJob($id);

        if (!$result) return back()->with('error', 'Xóa công việc thất bại');

        return back()->with('success', 'Xóa công việc thành công');
    }

    public function updateApplyStatus(UpdateStatusJobUniversity $request, Job $job, University $university)
    {
        $status = $request->status;

        $result = $this->jobService->updateApplyStatus($status, $job, $university,);

        if (!$result) return response()->json(['message' => 'Cập nhật trạng thái thất bại']);

        return response()->json(['data' => ['message' => 'Cập nhật trạng thái thành công']]);
    }
}
