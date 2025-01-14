<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Admin\MajorService;
use Illuminate\Http\Request;

class MajorController extends Controller
{
    const PATH_VIEW = 'admin.majors.index';

    public $majorService;

    public function __construct(MajorService $majorService)
    {
        $this->majorService = $majorService;
    }

    public function index()
    {

        return view(self::PATH_VIEW);
    }

    public function store(Request $request)
    {
        if ($this->majorService->create($request)) {

            return back()->with('success', 'Thêm mới chuyên ngành thành công.');
        }

        return back()->withInput()->with('error', 'Thêm mới chuyên ngành thất bại. Hãy thử lại.');
    }

    public function approve($id)
    {
        if ($this->majorService->approve($id)) {

            return redirect()->route('system-admin.major.list')->with('success', 'Phê duyệt major thành công');
        }

        return back()->with('error', 'Phê duyệt major thất bại');
    }

    public function reject(Request $request, $id)
    {
        if ($this->majorService->reject($id, $request->reason)) {

            return response()->json(['status' => true], 200);
        }

        return response()->json(['status' => false], 500);
    }
}
