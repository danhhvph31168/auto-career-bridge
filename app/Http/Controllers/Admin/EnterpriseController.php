<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Admin\EnterpriseService;
use Illuminate\Http\Request;

/**
 * Class EnterpriseController
 * @package App\Http\Controllers\Admin
 */
class EnterpriseController extends Controller
{
    /**
     * @var EnterpriseService $enterpriseService
     */
    protected $enterpriseService;

    /**
     * EnterpriseController constructor.
     * @param EnterpriseService $enterpriseService
     */
    public function __construct(EnterpriseService $enterpriseService)
    {
        $this->enterpriseService = $enterpriseService;
    }

    /**
     * Display a listing of enterprises.
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $admin_enterprises = $this->enterpriseService->getAll($request);
        $config = config('admin.enterprise');
        return view('admin.enterprises.index', compact('admin_enterprises', 'config'));
    }

    /**
     * Display the details of a specific enterprise.
     *
     * @param int $id
     * @return \Illuminate\View\View|void
     */
    public function show($id)
    {
        $config = config('admin.enterprise');
        $admin_enterprise = $this->enterpriseService->findById($id);
        if ($admin_enterprise) {
            return view('admin.enterprises.show', compact('admin_enterprise', 'config'));
        }
    }

    /**
     * Approve a specific enterprise account.
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function approve($id)
    {
        $data = $this->enterpriseService->approve($id);
        if ($data) {
            return redirect()->route('system-admin.enterprise.index')->with('success', 'Phê duyệt tài khoản thành công');
        }

        return redirect()->back()->with('error', 'Có lỗi khi phê duyệt tài khoản');
    }

    /**
     * Un approve a specific enterprise account.
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function unApprove(Request $request, $id)
    {
        $data = $this->enterpriseService->unApprove($request->reason, $id);
        if ($data) {
            return redirect()->route('system-admin.enterprise.index')->with('success', 'Huỷ phê duyệt tài khoản thành công');
        }

        return redirect()->back()->with('error', 'Có lỗi khi huỷ phê duyệt tài khoản');
    }

    /**
     * Remove a specific enterprise account.
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $data = $this->enterpriseService->destroy($id);
        if ($data) {
            return redirect()->route('system-admin.enterprise.index')->with('success', 'Xóa tài khoản thành công');
        }
        return redirect()->back()->with('error', 'Có lỗi khi xóa tài khoản');
    }
}
