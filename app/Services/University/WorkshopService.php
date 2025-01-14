<?php

namespace App\Services\University;

use App\Models\Workshop;
use App\Models\Enterprise;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Repositories\Major\MajorRepository;
use App\Repositories\University\Workshop\WorkShopRepositoryInterface as WorkShopRepository;
use App\Services\NotificationService;
use App\Repositories\Users\UserRepositoryInterface;

class WorkshopService
{
    protected $workShopRepository;
    protected $majorRepository;
    protected $notificationService;
    protected $userRepository;

    /**
     * WorkshopService constructor.
     *
     * @param WorkShopRepository $workShopRepository The repository to handle workshop-related data operations.
     */
    public function __construct(
        WorkShopRepository $workShopRepository,
        MajorRepository $majorRepository,
        NotificationService $notificationService,
        UserRepositoryInterface $userRepository,
    ) {
        $this->workShopRepository = $workShopRepository;
        $this->majorRepository = $majorRepository;
        $this->notificationService = $notificationService;
        $this->userRepository = $userRepository;
    }

    /**
     * Paginate workshops based on the provided filters and pagination settings.
     *
     * @param mixed $request
     *
     * @return [type]
     */
    public function paginate($request)
    {
        $university_id = Auth::user()->university_id;

        $condition = [
            'university_id' => $university_id,
            'title' => $request->input('name'),
            'start_date' => $request->input('start_date'),
            'end_date' => $request->input('end_date'),
        ];

        $perPage = $request->input('perPage') ?? 10;

        return $this->workShopRepository->getWorkShop($condition, $perPage);
    }

    /**
     * Get major with university_id
     *
     * @return [type]
     */
    public function getMajorUniversityApproved()
    {
        $university_id = Auth::user()->university_id;
        $condition = [
            'university_id' => $university_id
        ];

        return $this->majorRepository->getMajorUniversityApproved($condition);
    }


    /**
     * Create a new workshop for the authenticated user's university.
     *
     * @param mixed $request
     *
     * @return [type]
     */
    public function create($request)
    {
        DB::beginTransaction();

        $universityId = Auth::user()->university_id;

        try {
            $data = $request->only([
                'university_id',
                'title',
                'address',
                'requirement',
                'description',
                'start_date',
                'end_date',
                'status',
            ]);

            $data['university_id'] = $universityId;

            $data['slug'] = Str::slug(Str::limit($data['title'], 200)  . ' ' . uniqid());

            $workshops = $this->workShopRepository->create($data);

            if ($request->has('majors')) {
                $majorIds = $request->input('majors');
                $workshops->majors()->attach($majorIds);
            }

            $notify = [
                'title' => NOTIFY_CREATE_WORKSHOP. ' ' . $workshops->university->name,
                'message' => NOTIFY_CREATE_MESSAGE_WORKSHOP,
                'type' => 0,
            ];

            $send_id = Auth::user()?->id;

            $receiver_id = $this->userRepository->getUserSupperAdmin()->first();


            if (!$receiver_id) return false;

            $this->notificationService->createNotification($send_id, $receiver_id->id, $notify);

            DB::commit();

            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            dd($e->getMessage());
            report($e);

            return false;
        }
    }

    /**
     * Find a workshop by its ID.
     *
     * @param mixed $id
     *
     * @return [type]
     */
    public function findById($id)
    {
        $workshops = Workshop::with('majors')->find($id);

        if ($workshops) {
            $majors = $workshops->majors;

            return [
                'majors' => $majors,
                'workshops' => $workshops,
            ];
        }
        return $this->workShopRepository->findById($id);
    }

    /**
     * Update a workshop and sync majors.
     *
     * @param int $id
     * @param \Illuminate\Http\Request $request
     * @return bool
     */
    public function update($id, $request)
    {
        DB::beginTransaction();

        try {
            $workShopUniversity = $this->workShopRepository->findById($id);

            if (!$workShopUniversity) {
                throw new \Exception('Workshop not found.');
            }

            $data = array_merge(
                $request->except(['_token', 'send']),
                ['status' => PENDING_APPROVE]
            );

            $workshops = $this->workShopRepository->update($id, $data);

            if ($request->has('majors') && is_array($request->input('majors'))) {
                $majorIds = $request->input('majors');
                $workshops->majors()->sync($majorIds);
            }

            $notify = [
                'title' => NOTIFY_UPDATE_WORKSHOP. ' ' . Auth::user()?->username,
                'message' => NOTIFY_UPDATE_MESSAGE_WORKSHOP,
                'type' => 0,
            ];

            $send_id = Auth::user()?->id;

            $receiver_id = $this->userRepository->getUserSupperAdmin()->first();


            if (!$receiver_id) return false;

            $this->notificationService->createNotification($send_id, $receiver_id->id, $notify);

            DB::commit();

            return true;
        } catch (\Exception $e) {
            DB::rollBack();

            return false;
        }
    }

    /**
     * Delete a workshop by its ID.
     *
     * This method starts a transaction, deletes the workshop, and commits the transaction.
     * If any error occurs, the transaction is rolled back.
     *
     * @param mixed $id
     *
     * @return [type]
     */
    public function destroy($id)
    {
        DB::beginTransaction();

        try {
            $this->workShopRepository->destroy($id);

            DB::commit();

            return true;
        } catch (\Exception $e) {
            DB::rollBack();

            return false;
        }
    }

    /**
     * Update the status of a workshop (active/unactive).
     *
     * @param array $post
     *
     * @return [type]
     */
    public function updateStatus($post = [])
    {
        DB::beginTransaction();

        try {
            $data[$post['field']] = ($post['value'] == IS_ACTIVE) ? UN_ACTIVE : IS_ACTIVE;

            $this->workShopRepository->update($post['modelId'], $data);

            DB::commit();

            return true;
        } catch (\Exception $e) {
            DB::rollBack();

            return false;
        }
    }

    public function getDashboardData(int $year)
    {
        $countAll = $this->workShopRepository->countAll();

        $countAccept = $this->workShopRepository->countAccept();

        $acceptPercentage = ($countAll > 0 && $countAccept > 0) ? round(($countAccept / $countAll) * 100) : 0;

        $countApplicants = $this->workShopRepository->sumApplicants($year);

        $countApplyPending = $this->workShopRepository->countApply(PENDING_APPROVE, $year);

        $countApplyNotAccept = $this->workShopRepository->countApply(UN_APPROVE, $year);

        $countApplyAccept = $this->workShopRepository->countApply(APPROVED, $year);

        $countApplyAcceptByMonthRaw = $this->workShopRepository->countApplyByMonth(APPROVED, $year);

        $countApplyNotAcceptByMonthRaw = $this->workShopRepository->countApplyByMonth(UN_APPROVE, $year);

        $countApplyPendingByMonthRaw = $this->workShopRepository->countApplyByMonth(PENDING_APPROVE, $year);

        $countApplyAcceptByMonth = [];
        $countApplyNotAcceptByMonth = [];
        $countApplyPendingByMonth = [];

        for ($month = 1; $month <= 12; $month++) {
            $countApplyAcceptByMonth[] = $countApplyAcceptByMonthRaw[$month] ?? 0;
            $countApplyNotAcceptByMonth[] = $countApplyNotAcceptByMonthRaw[$month] ?? 0;
            $countApplyPendingByMonth[] = $countApplyPendingByMonthRaw[$month] ?? 0;
        }

        return [
            'countAll' => $countAll,
            'countAccept' => $countAccept,
            'acceptPercentage' => $acceptPercentage,
            'countApplicants' => $countApplicants,
            'countApplyPending' => $countApplyPending,
            'countApplyNotAccept' => $countApplyNotAccept,
            'countApplyAccept' => $countApplyAccept,
            'countApplyAcceptByMonth' => $countApplyAcceptByMonth,
            'countApplyNotAcceptByMonth' => $countApplyNotAcceptByMonth,
            'countApplyPendingByMonth' => $countApplyPendingByMonth,
        ];
    }

    public function updateApplyStatus(int $status, Workshop $workshop, Enterprise $enterprise)
    {
        return $this->workShopRepository->updateApplyStatus($status, $workshop, $enterprise);
    }
}
