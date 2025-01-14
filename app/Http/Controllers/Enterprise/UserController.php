<?php

namespace App\Http\Controllers\Enterprise;

use App\Exports\UsersExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\Enterprise\User\ImportUserRequest;
use App\Http\Requests\Enterprise\User\StoreUserRequest;
use App\Http\Requests\Enterprise\User\UpdateUserRequest;
use App\Models\Enterprise;
use App\Models\Role;
use App\Models\User;
use App\Services\Enterprise\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class UserController extends Controller
{
    const PATH_VIEW = 'enterprise.users.';

    public function __construct(protected UserService $userService) {}
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage = $request->perPage ?? 10;

        $search = $request->get('keyword', '');

        $users = $this->userService->getAllUsers($perPage, $search);

        return view(self::PATH_VIEW . __FUNCTION__, compact('users', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Role::select('id', 'name')->get();

        return view(self::PATH_VIEW . __FUNCTION__, compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        $this->userService->createUser($request->all());

        return redirect()->route('enterprise.users.index')->with('success', 'Thêm mới nhân viên thành công');
    }

    /**
     * Show the form for detail the specified resource.
     */
    public function show($id)
    {
        $enterprises = Enterprise::find($id);
        if ($enterprises) {
            return response()->json([
                'enterprise' => $enterprises,
            ]);
        }

        return response()->json(['error' => 'Doanh nghiệp không tồn tại'], 404);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        $roles = Role::select('id', 'name')->get();

        return view(self::PATH_VIEW . __FUNCTION__, compact('user', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, int $id)
    {
        $result = $this->userService->updateUser($id, $request->all());

        if (!$result) return back()->with('error', 'Cập nhật nhân viên thất bại');

        return redirect()->route('enterprise.users.index')->with('success', 'Cập nhật nhân viên thành công');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        $result = $this->userService->destroyUser($id);

        if (!$result) return back()->with('error', 'Xóa nhân viên thất bại');

        return back()->with('success', 'Xóa nhân viên thành công');
    }

    public function import(ImportUserRequest $request)
    {
        $result = $this->userService->importUsers($request->json('data'));

        return response()->json($result);
    }

    public function export()
    {
        return Excel::download(new UsersExport, 'users.xlsx');
    }

    public function updateIsActive(Request $request, User $user)
    {
        $data = $request->only('is_active');

        $request->validate([
            'is_active' => 'required|in:' . IS_ACTIVE . ',' . UN_ACTIVE,
        ], [
            'is_active.required' => 'Trạng thái không được để trống.',
            'is_active.in' => 'Trạng thái không hợp lệ.',
        ]);

        $result = $this->userService->updateUser($user->id, $data);

        if (!$result) return response()->json(['message' => 'Cập nhật trạng thái thất bại'], 500);

        return response()->json(['data' => ['message' => 'Cập nhật trạng thái thành công']]);
    }
}
