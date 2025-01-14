<?php

namespace App\Services\University;

use App\Models\Major;
use App\Models\University;
use App\Repositories\Major\MajorRepositoryInterface;
use App\Services\NotificationService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Repositories\Users\UserRepositoryInterface;

class MajorService
{
    protected $majorRepository;
    protected $notificationService;
    protected $userRepository;

    public function __construct(
        MajorRepositoryInterface $majorRepository,
        NotificationService $notificationService,
        UserRepositoryInterface $userRepository,
    ) {
        $this->majorRepository = $majorRepository;
        $this->notificationService = $notificationService;
        $this->userRepository = $userRepository;
    }

    public function getMajor($request)
    {
        $university_id = Auth::user()->university_id;
        $condition = [
            'keyword' => $request->input('keyword'),
            'university_id' => $university_id
        ];
        $perPage = $request->input('perPage') ?? 10;

        return $this->majorRepository->getMajorUniversity($condition, $perPage);
    }

    public function create($request)
    {
        DB::beginTransaction();
        try {
            $data = $request->only([
                'name',
                'description',
            ]);

            $major = $this->majorRepository->create($data);

            if (isset($major->id)) {
                $universityId = Auth::user()->university_id;

                $university = University::find($universityId);

                if ($university) {

                    $university->majors()->attach($major->id);
                } else {

                    throw new \Exception('Trường đại học không tồn tại.');
                }
            }

            $notify = [
                'title' => NOTIFY_CREATE_MAJOR . ' ' . Auth::user()?->username,
                'message' => NOTIFY_CREATE_MESSAGE_MAJOR,
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
            report($e);

            return false;
        }
    }

    public function update($id, $request)
    {
        DB::beginTransaction();
        try {
            $data = $request->except(['_token', 'send']);
            $data['status'] = PENDING_APPROVE;

            $this->majorRepository->update($id, $data);

            $notify = [
                'title' => NOTIFY_UPDATE_MAJOR . ' ' . Auth::user()?->username,
                'message' => NOTIFY_UPDATE_MESSAGE_MAJOR,
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
            report($e);

            return false;
        }
    }

    public function findById($id)
    {
        return $this->majorRepository->findById($id);
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $major = Major::findOrFail($id);
            $major->universities()->detach();
            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            return false;
        }
    }
}
