<?php

namespace App\Services\Admin;

use App\Models\Enterprise;
use App\Models\Notification;
use App\Models\University;
use App\Models\User;
use App\Notifications\AccountEnterpriseApprove;
use App\Notifications\AccountEnterpriseDelete;
use App\Notifications\AccountEnterpriseDeleteForUniversity;
use App\Repositories\Admin\Enterprise\EnterpriseRepositoryInterface;
use App\Repositories\Notification\NotificationRepositoryInterface;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * Class EnterpriseService
 * @package App\Services\Admin
 */
class EnterpriseService
{
    /**
     * @var EnterpriseRepositoryInterface $enterpriseRepository
     * @var NotificationService $notificationService
     */
    protected $enterpriseRepository;
    protected $notificationService;

    /**
     * EnterpriseService constructor.
     *
     * @param EnterpriseRepositoryInterface $enterpriseRepository
     */
    public function __construct(EnterpriseRepositoryInterface $enterpriseRepository, NotificationService $notificationService)
    {
        $this->enterpriseRepository = $enterpriseRepository;
        $this->notificationService = $notificationService;
    }

    /**
     * Get a paginated list of enterprises with search filters.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getAll($request)
    {
        $search = $request->only(['q', 'status']);
        return $this->enterpriseRepository->getAllEnterprise(10, $search);
    }

    /**
     * Find an enterprise by ID.
     *
     * @param int $id
     * @return \App\Models\User
     */
    public function findById($id)
    {
        return $this->enterpriseRepository->findById($id);
    }

    /**
     * Approve an enterprise account.
     *
     * @param int $idp
     * @return bool
     */
    public function approve($id)
    {
        $admin_enterprise = $this->enterpriseRepository->findById($id);
        DB::beginTransaction();
        try {
            if ($admin_enterprise) {
                $this->enterpriseRepository->update($id, ['status' => APPROVED, 'is_active' => IS_ACTIVE]);
                $admin_enterprise->enterprise->update([
                    'is_verify' => true
                ]);
                $admin_enterprise->notify(new AccountEnterpriseApprove($admin_enterprise));

                $super_admin = User::where('user_type', 'super-admin')->first();


                $data_notify = [
                    'type' => 'system',
                    'title' => 'Thông báo phê duyệt tài khoản',
                    'message' => 'Tài khoản của bạn đã được phê duyệt',
                ];

                $this->notificationService->createNotification($super_admin->id, $admin_enterprise->id, $data_notify);
            }
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            return false;
        }
    }

    /**
     * Un approve an enterprise account.
     *
     * @param int $id
     * @return bool
     */
    public function unApprove(string $reason, $id)
    {
        $admin_enterprise = $this->enterpriseRepository->findById($id);
        DB::beginTransaction();
        try {
            if ($admin_enterprise) {
                $this->enterpriseRepository->update($id, [
                    'status' => UN_APPROVE,
                    'rejection_reason' => $reason
                ]);
                $admin_enterprise->notify(new AccountEnterpriseApprove($admin_enterprise, $reason));

                $super_admin = User::where('user_type', 'super-admin')->first();

                $data_notify = [
                    'type' => 'system',
                    'title' => 'Thông báo huỷ phê duyệt tài khoản',
                    'message' => 'Tài khoản của bạn không được phê duyệt. Lý do:' . $reason,
                ];

                $this->notificationService->createNotification($super_admin->id, $admin_enterprise->id, $data_notify);
            }
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            return false;
        }
    }

    /**
     * Delete an enterprise account.
     *
     * @param int $id
     * @return bool
     */
    public function destroy($id)
    {
        $super_admin = User::where('user_type', 'super-admin')->first();
        DB::beginTransaction();
        try {
            $user = $this->enterpriseRepository->findById($id);

            if ($user) {
                $enterprise = $user->enterprise;
                $enterpriseId = $user->enterprise_id;
                if ($enterpriseId) {
                    $enterprise = Enterprise::find($enterpriseId);

                    $universityIds = DB::table('workshop_enterprise')
                        ->join('workshops', 'workshop_enterprise.workshop_id', '=', 'workshops.id')
                        ->where('workshop_enterprise.enterprise_id', $enterprise->id)
                        ->pluck('workshops.university_id')
                        ->merge(DB::table('collaborations')
                            ->where('enterprise_id', $enterprise->id)
                            ->pluck('university_id'))
                        ->merge(DB::table('job_university')
                            ->whereIn('job_id', $enterprise->jobs->pluck('id'))
                            ->pluck('university_id'))
                        ->unique();


                    foreach ($universityIds as $universityId) {
                        $universityUsers = User::where('university_id', $universityId)->get();
                        foreach ($universityUsers as $university) {
                            $university->notify(new AccountEnterpriseDeleteForUniversity($enterprise));

                            $data_notify = [
                                'type' => 'system',
                                'title' => 'Doanh nghiệp không còn hoạt động',
                                'message' => 'Doanh nghiệp ' . $enterprise->name . ' mà bạn hợp tác không còn hoạt động. Tất cả các công việc, hợp tác và hoạt động liên quan đến doanh nghiệp này sẽ không còn hiệu lực',
                            ];

                            $this->notificationService->createNotification($super_admin->id, $university->id, $data_notify);
                        }
                    }

                    $user->notify(new AccountEnterpriseDelete($user));


                    if ($enterprise) {
                        $enterprise->jobs()->each(function ($job) {
                            DB::table('job_university')->where('job_id', $job->id)
                                ->update(['deleted_at' => now()]);

                            $job->delete();
                        });
                        DB::table('collaborations')
                            ->where('enterprise_id', $enterpriseId)
                            ->update(['deleted_at' => now()]);

                        DB::table('workshop_enterprise')->where('enterprise_id', $enterpriseId)
                            ->update(['deleted_at' => now()]);

                        Notification::where('sender_id', $user->id)
                            ->orWhere('receiver_id', $user->id)
                            ->delete();

                        $enterprise->delete();
                    }
                    $user->delete();
                }
            }
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            return false;
        }
    }
}
