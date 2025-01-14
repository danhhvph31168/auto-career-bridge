<?php

namespace App\Services\Auth;

use App\Models\User;
use App\Repositories\Auth\RegisterRepositoryInterface;
use App\Services\NotificationService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

/**
 * Class RegisterService
 * Handle the business logic related to register user.
 *
 */
class RegisterService
{
    protected $registerRepository;
    protected $notificationService;

    /**
     * Constructor
     *
     * @param RegisterRepositoryInterface $registerRepository
     */

    public function __construct(RegisterRepositoryInterface $registerRepository, NotificationService $notificationService)
    {
        $this->registerRepository = $registerRepository;
        $this->notificationService = $notificationService;
    }

    /**
     * Create a new user.
     *
     * @param \Illuminate\Http\Request $request data from the client.
     * @return bool True if the creation is successful, otherwise False.
     */

    public function create($request)
    {
        DB::beginTransaction();
        try {
            $data = $request->only([
                'email',
                'username',
                'phone',
                'password',
                'user_type',
                'role_id'
            ]);
            $data['password'] = Hash::make($data['password']);

            $user = $this->registerRepository->create($data);

            $data_notify = [
                'type' => NOTIFY_REGISTER_TYPE,
                'title' => NOTIFY_TITLE_REGISTER,
                'message' => 'Người dùng ' . $user->username . ' vừa đăng ký tài khoản',
            ];

            $super_admin = User::where('user_type', 'super-admin')->first();

            $this->notificationService->createNotification($user->id, $super_admin->id, $data_notify);
            DB::commit();
            return $user;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            report($e);
            return false;
        }
    }
}
