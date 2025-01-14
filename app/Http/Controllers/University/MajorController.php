<?php

namespace App\Http\Controllers\University;

use App\Http\Requests\University\StoreMajor;
use App\Services\University\MajorService;
use Illuminate\Http\Request;

class MajorController
{
    protected $majorService;

    public function __construct(MajorService $majorService)
    {
        $this->majorService = $majorService;
    }

    public function index(Request $request)
    {
        $config = config('admin.university');
        $template = 'university.major.index';

        $majors = $this->majorService->getMajor($request);

        return view($template, compact('config', 'majors'));
    }
    
    public function store(StoreMajor $request)
    {
        if ($this->majorService->create($request)) {

            return redirect()->route('university.major.index')->with('success', 'Thêm mới chuyên ngành thành công.');
        }

        return back()->withInput()->with('error', 'Thêm mới chuyên ngành thất bại. Hãy thử lại.');
    }

    public function edit($id)
    {
        $major = $this->majorService->findById($id);

        if ($major) {
            return response()->json([
                'id' => $major->id,
                'name' => $major->name,
                'description' => $major->description,
            ]);
        }

        return response()->json(['error' => 'Chuyên ngành không tồn tại'], 404);
    }

    public function update($id, Request $request)
    {
        $result = $this->majorService->update($id, $request);

        if ($result) {
            session()->flash('success', 'Cập nhật thành công!');

            return response()->json([
                'success' => true,
                'message' => 'Cập nhật thành công!'
            ]);
        } else {
            
            return response()->json([
                'success' => false,
                'message' => 'Cập nhật thất bại. Vui lòng thử lại.'
            ]);
        }
    }

    public function destroy($id)
    {
        if ($this->majorService->destroy($id)) {

            return redirect()->route('university.major.index')->with('success', 'Xóa bản ghi thành công.');
        }

        return redirect()->route('university.major.index')->with('error', 'Xóa bản ghi thất bại. Hãy thử lại.');
    }


}
