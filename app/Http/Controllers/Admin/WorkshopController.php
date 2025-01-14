<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\University;
use App\Repositories\University\Workshop\WorkShopRepository;
use App\Services\Admin\WorkshopService;
use Illuminate\Http\Request;
use Carbon\Carbon;

class WorkshopController extends Controller
{
    const PATH_VIEW = 'admin.universities.workshops.index';
    protected $workshopRepository;
    protected $workshopService;

    public function __construct(
        WorkShopRepository $workshopRepository,
        WorkshopService $workshopService
    ) {
        $this->workshopRepository = $workshopRepository;
        $this->workshopService = $workshopService;
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
        $config = config('admin.workshop');
        $workshop = $this->workshopRepository->findById($id);
        $university = $workshop->university;
        if (!$university) {

            return back()->with('warning', 'Thông tin trường học không tồn tại');
        }

        if (!$workshop) {

            return abort(404);
        }

        $majors = $workshop->majors;

        return view(self::PATH_VIEW, [
            'page' => $page,
            'university' => $university,
            'majors' => $majors,
            'workshop' => $workshop,
            'config' => $config
        ]);
    }

    public function approve($id)
    {
        if ($this->workshopService->approve($id)) {

            return redirect()->route('system-admin.workshop.list')->with('success', 'Phê duyệt workshop thành công');
        }

        return back()->with('error', 'Phê duyệt workshop thất bại');
    }

    public function reject(Request $request, $id)
    {
        if ($this->workshopService->reject($id, $request->reason)) {

            return response()->json(['status' => true], 200);
        }

        return response()->json(['status' => false], 500);
    }
}
