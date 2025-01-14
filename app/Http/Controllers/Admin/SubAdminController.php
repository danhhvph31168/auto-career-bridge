<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreSubAdminRequest;
use App\Http\Requests\Admin\UpdateSubAdminRequest;
use App\Services\SubAdmin\SubAdminService;
use Illuminate\Http\Request;

class SubAdminController extends Controller
{
    protected $subAdminService;
    const PATH_VIEW = 'admin.sub-admin.';

    public function __construct(SubAdminService $subAdminService)
    {
        $this->subAdminService = $subAdminService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $config = config('apps.sub-admin');
        $sub_admins = $this->subAdminService->paginate($request);
        return view(self::PATH_VIEW . __FUNCTION__, compact('config', 'sub_admins'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $config = config('apps.sub-admin');
        return view(self::PATH_VIEW . __FUNCTION__, compact('config'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSubAdminRequest $request)
    {
        if ($this->subAdminService->create($request)) {
            return redirect()->route('system-admin.sub-admin.index')->with('success', 'Thêm mới sub-admin thành công.');
        }
        return back()->with('error', 'Có lỗi khi thêm mới. Hãy thử lại.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $config = config('apps.sub-admin');
        $sub_admin = $this->subAdminService->findById($id);
        if ($sub_admin) {
            return view(self::PATH_VIEW . __FUNCTION__, compact('sub_admin', 'config'));
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $config = config('apps.sub-admin');
        $sub_admin = $this->subAdminService->findById($id);
        return view(self::PATH_VIEW . __FUNCTION__, compact('config', 'sub_admin'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSubAdminRequest $request, string $id)
    {
        if ($this->subAdminService->update($id, $request)) {
            return redirect()->route('system-admin.sub-admin.index')->with('success', 'Cập nhật sub-admin thành công.');
        }
        return back()->with('error', 'Có lõi khi cập nhật. Hãy thử lại.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if ($this->subAdminService->destroy($id)) {
            return redirect()->route('system-admin.sub-admin.index')->with('success', 'Xóa sub-admin thành công.');
        }
        return redirect()->route('system-admin.sub-admin.index')->with('error', 'Có lõi khi xoá. Hãy thử lại.');
    }
}
