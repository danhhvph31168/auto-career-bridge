<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\Major\MajorRepository;
use App\Repositories\Notification\NotificationRepository;
use App\Repositories\Users\UserRepository;
use App\Services\Admin\UniversityService;
use Illuminate\Http\Request;

class UniversityController extends Controller
{
    const PATH_VIEW = 'admin.universities.users.index';
    public $userRepository;
    public $universityService;
    public $majorRepository;
    public $notificationRepository;

    public function __construct(
        UserRepository $userRepository,
        UniversityService $universityService,
        MajorRepository $majorRepository,
        NotificationRepository $notificationRepository
    ) {
        $this->userRepository = $userRepository;
        $this->universityService = $universityService;
        $this->majorRepository = $majorRepository;
        $this->notificationRepository = $notificationRepository;
    }

    public function index()
    {
        $page = 'list';

        return view(self::PATH_VIEW, [
            'page' => $page,
        ]);
    }

    public function detail($id)
    {
        $page = 'detail';
        $user = $this->userRepository->findById($id);
        $university = $user->university;
        if (!$university) {

            return back()->with('warning', 'Thông tin trường học không tồn tại');
        }
        $config = config('admin.university.approve');

        if (!$user) {

            return abort(404);
        }

        $condition = [
            'university_id' => $university->id,
        ];
        $majors = $this->majorRepository->getMajorUniversityApproved($condition);

        return view(self::PATH_VIEW, [
            'page' => $page,
            'user' => $user,
            'university' => $university,
            'majors' => $majors,
            'config' => $config
        ]);
    }

    public function approve($id)
    {
        if ($this->universityService->approve($id)) {

            return redirect()->route('system-admin.university.users')->with('success', 'Phê duyệt tài khoản thành công');
        }

        return redirect()->route('system-admin.university.detal', $id)->with('error', 'Phê duyệt tài khoản thất bại');
    }

    public function reject(Request $request, $id)
    {
        if ($this->universityService->reject($id, $request->reason)) {

            return response()->json(['status' => true], 200);
        }

        return response()->json(['status' => false], 500);
    }
}
