<?php

namespace App\Http\Controllers\University;

use App\Http\Controllers\Controller;
use App\Services\University\UserService;
use Illuminate\Http\Request;
use App\Http\Requests\University\StoreUserRequest;
use App\Http\Requests\University\UpdateUserRequest;
use App\Exports\UserTemplateExcel;
use App\Exports\UserExport;
use App\Http\Requests\Enterprise\User\ImportUserRequest;
use App\Imports\UsersImport;
use Maatwebsite\Excel\Facades\Excel;

class UserController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Display a list users from the university with paginate.
     * 
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $config = config('apps.university');
        $template = 'university.users.index';
        $universities = $this->userService->paginate($request);

        return view($template, compact('config', 'universities'));
    }
    /**
     * Show the form to create a new user.
     * 
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $config = config('apps.university');
        $template = 'university.users.create';

        return view($template, compact('config'));
    }
    /**
     * Handle the request to store a new user in the database.
     * 
     * @param StoreUserUniversityRequest $request
     * 
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreUserRequest $request)
    {
        if ($this->userService->create($request)) {

            return redirect()->route('university.index')->with('success', 'Thêm mới bản ghi thành công.');
        }

        return redirect()->route('university.create')->with('error', 'Thêm mới bản ghi thất bại. Hãy thử lại.');
    }

    /**
     * Show form to edit a users information
     * 
     * @param int $id the ID of the user.
     * 
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $config = config('apps.university');
        $template = 'university.users.edit';
        $userUniversity = $this->userService->findById($id);

        return view($template, compact('config', 'userUniversity'));
    }

    /**
     * Update a user information $request The data from the update form.
     * 
     * @param int $id The ID of the user.
     * @param UpdateUserUniversityRequest $request The data from the update form.
     * 
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update($id, UpdateUserRequest $request)
    {
        if ($this->userService->update($id, $request)) {

            return redirect()->route('university.index')->with('success', 'Cập nhật bản ghi thành công.');
        }

        return redirect()->route('university.index')->with('error', 'Cập nhật bản ghi thất bại. Hãy thử lại.');
    }

    /**
     * Delete a user form the system.
     * 
     * @param int $id the ID of the user.
     * 
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        if ($this->userService->destroy($id)) {

            return redirect()->route('university.index')->with('success', 'Xóa bản ghi thành công.');
        }

        return redirect()->route('university.index')->with('error', 'Xóa bản ghi thất bại. Hãy thử lại.');
    }

    /**
     * Export the list of users as an Excel file
     * 
     * @return \Maatwebsite\Excel\Excel;
     */
    public function userExportExcelFileUser()
    {

        return Excel::download(new UserExport($this->userService), 'Danh sách giáo vụ.xlsx');
    }

    /**
     * Export a sample Excel file for users
     * 
     * @return \Maatwebsite\Excel\Excel;
     */
    public function exportExcelFile()
    {
        return Excel::download(new UserTemplateExcel, 'Danh sách giáo vụ mẫu.xlsx');
    }

    /**
     * Import users form an Excel file
     * 
     * @param Request $request
     * 
     * @return [type]
     */
    public function importExcelFile(ImportUserRequest $request)
    {
        $result = $this->userService->importUsers($request->json('data'));

        return response()->json($result);
    }
}
