<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Admin\JobService;
use Illuminate\Http\Request;

class JobController extends Controller
{
    const PATH_VIEW = 'admin.job.';
    protected $jobService;

    public function __construct(JobService $jobService)
    {
        $this->jobService = $jobService;
    }

    public function index(Request $request)
    {
        $jobs = $this->jobService->getAll($request);
        $config = config('admin.job');
        return view(self::PATH_VIEW . __FUNCTION__, compact('jobs', 'config'));
    }

    public function show($id)
    {
        $config = config('admin.job');
        $job = $this->jobService->findById($id);
        if ($job) {
            return view(SELF::PATH_VIEW . __FUNCTION__, compact('job', 'config'));
        }
    }

    public function approve($id)
    {
        $data = $this->jobService->approve($id);
        if ($data) {
            return redirect()->route('system-admin.job.index')->with('success', 'Phê duyệt công việc thành công');
        }

        return redirect()->back()->with('error', 'Có lỗi khi phê duyệt công việc');
    }

    public function unApprove(Request $request, $id)
    {
        $data = $this->jobService->unApprove($request->reason, $id);
        if ($data) {
            return redirect()->route('system-admin.job.index')->with('success', 'Công việc đã được huỷ phê duyệt');
        }
        return redirect()->back()->with('error', 'Có lỗi khi huỷ phê duyệt công việc');
    }

    public function destroy($id)
    {
        $message = $this->jobService->destroy($id);

        if ($message === true) {
            return redirect()->route('system-admin.job.index')->with('success', 'Xóa công việc thành công');
        } else {
            return redirect()->back()->with('error', $message);
        }
    }

}
