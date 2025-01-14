<?php

namespace App\Http\Controllers\University;

use App\Http\Controllers\Controller;
use App\Services\University\WorkshopService;
use Illuminate\Http\Request;
use App\Http\Requests\University\StoreWorkshopRequest;
use App\Http\Requests\University\UpdateWorkshopRequest;
use App\Models\Enterprise;
use App\Models\Workshop;

/**
 * Class WorkshopController
 *
 * Manages the operations related to university workshops.
 *
 * @package App\Http\Controllers\University
 */
class WorkshopController extends Controller
{
    /**
     * @var WorkshopService
     * Service to handle workshop-related operations.
     */
    protected $workShopService;

    /**
     * WorkshopController constructor.
     *
     * @param WorkshopService $workShopService
     * The workshop service instance.
     */
    public function __construct(WorkshopService $workShopService)
    {
        $this->workShopService = $workShopService;
    }

    /**
     * Display a listing of the workshops.
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $config = config('apps.workshop');
        $template = 'university.workshops.index';
        $workshops = $this->workShopService->paginate($request);

        return view($template, compact('config', 'workshops'));
    }

    /**
     * Show the form for creating a new workshop.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $config = config('apps.workshop');
        $template = 'university.workshops.create';
        $majors = $this->workShopService->getMajorUniversityApproved();

        return view($template, compact('config', 'majors'));
    }

    /**
     * Store a newly created workshop in the database.
     *
     * @param StoreWorkshopRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreWorkshopRequest $request)
    {
        if ($this->workShopService->create($request)) {

            return redirect()->route('university.workshop.index')->with('success', 'Thêm mới bản ghi thành công.');
        }

        return back()->withInput()->with('error', 'Thêm mới bản ghi thất bại. Vui lòng thử lại');
    }

    /**
     * Display the specified workshop details.
     *
     * @param int $id
     * The ID of the workshop to display.
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $config = config('apps.workshop');
        $template = 'university.workshops.show';

        $majors = $this->workShopService->getMajorUniversityApproved();

        $data = $this->workShopService->findById($id);

        if (is_array($data)) {
            $major = $data['majors'];
            $workshops = $data['workshops'];
        }

        $workshops->load('enterprises');
        $enterprises = $workshops->enterprises()->paginate();
        
        return view($template, compact('config', 'majors', 'major', 'workshops', 'enterprises'));
    }

    /**
     * Show the form for editing the specified workshop.
     *
     * @param int $id
     * The ID of the workshop to edit.
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $config = config('apps.workshop');
        $template = 'university.workshops.edit';

        $major = $this->workShopService->getMajorUniversityApproved();
        $workshopUniversity = $this->workShopService->findById($id);

        if (is_array($workshopUniversity)) {
            $majors = $workshopUniversity['majors'];
            $workshops = $workshopUniversity['workshops'];
        }

        return view($template, compact('config', 'majors', 'major', 'workshops'));
    }

    /**
     * Update the specified workshop in the database.
     *
     * @param int $id
     * The ID of the workshop to update.
     * @param StoreWorkshopRequest $request
     * The data to update the workshop with.
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update($id, UpdateWorkshopRequest $request)
    {
        if ($this->workShopService->update($id, $request)) {

            return redirect()->route('university.workshop.index')->with('success', 'Cập nhật workshop thành công.');
        }

        return back()->withInput()->with('error', 'Cập nhật workshop thất bại.');
    }

    /**
     * Remove the specified workshop from the system.
     *
     * @param int $id
     * The ID of the workshop to delete.
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        if ($this->workShopService->destroy($id)) {

            return redirect()->route('university.workshop.index')->with('success', 'Xóa bản ghi thành công.');
        }
        return redirect()->route('university.workshop.index')->with('error', 'Xóa bản ghi thất bại.');
    }

    public function updateApplyStatus(Request $request, Workshop $workshop, Enterprise $enterprise)
    {
        $status = $request->status;

        $result = $this->workShopService->updateApplyStatus($status, $workshop, $enterprise,);

        if (!$result) return response()->json(['message' => 'Cập nhật trạng thái thất bại']);

        return response()->json(['data' => ['message' => 'Cập nhật trạng thái thành công']]);
    }
}
