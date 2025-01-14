<?php

namespace App\Services\Client;

use App\Repositories\Collaboration\CollaborationRepositoryInterface;
use App\Repositories\Enterprises\EnterpriseRepositoryInterface;
use App\Repositories\Enterprises\User\UserRepositoryInterface;
use App\Repositories\University\UniversityRepositoryInterface;
use App\Repositories\University\User\UserRepositoryInterface as UserUserRepositoryInterface;
use App\Services\NotificationService;
use Illuminate\Support\Facades\Auth;

use function PHPUnit\Framework\isNull;

class CollaborationService
{
    public function __construct(
        protected CollaborationRepositoryInterface $collaborationRepository,
        protected UniversityRepositoryInterface $universityRepository,
        protected EnterpriseRepositoryInterface $enterpriseRepository,
        protected NotificationService $notificationService,
        protected UserRepositoryInterface $userEnterpriseRepository,
        protected UserUserRepositoryInterface $userUniversityRepository,
    ) {}

    public function sendByUniversity(int $enterprise_id)
    {
        $university_id = Auth::user()->university_id;

        if (!$university_id) return false;

        $enterprise = $this->enterpriseRepository->getById($enterprise_id);

        if (!$enterprise) return false;

        $existCollaboration = $this->collaborationRepository->findByUniversityAndEnterprise($university_id, $enterprise_id);

        if ($existCollaboration) return false;

        $data = [
            'title' => SEND_COLLABORATION,
            'message' => SEND_COLLABORATION,
            'type' => NOTIFY_COOPERATE,
        ];

        $result = $this->createNotification($enterprise_id, $university_id, $data, TYPE_UNIVERSITY);

        if (!$result) return false;

        return $this->collaborationRepository->create([
            'university_id' => $university_id,
            'enterprise_id' => $enterprise_id,
            'send_name' => TYPE_UNIVERSITY,
        ]);
    }

    public function createNotification(int $enterprise_id, int $university_id, array $data, string $user_send)
    {
        $user_ids = $this->getSenderAndReceiverIds($enterprise_id, $university_id, $user_send);

        if (!$user_ids) return false;

        [$sender_ids, $receiver_ids] = $user_ids;

        return $this->notificationService->createNotification($sender_ids[0], $receiver_ids[0],  $data);
    }

    public function deleteNotification(int $enterprise_id, int $university_id, string $user_send)
    {
        $user_ids = $this->getSenderAndReceiverIds($enterprise_id, $university_id, $user_send);

        if (!$user_ids) return false;

        [$sender_ids, $receiver_ids] = $user_ids;

        return $this->notificationService->deleteNotification($sender_ids, $receiver_ids);
    }

    public function getCollaborationByEnterprise(int $perPage, string $search)
    {
        $enterprise_id = Auth::user()->enterprise_id ?? abort(403);

        return $this->enterpriseRepository->getCollaborationByEnterprise($enterprise_id, $perPage, $search);
    }

    public function updateCollaboration(int $university_id = null, int $enterprise_id = null, int $status)
    {
        if (!is_null($university_id) && is_null($enterprise_id)) {
            $enterprise_id = Auth::user()->enterprise_id ?? abort(403);
            $user_send = TYPE_ENTERPRISE;
            $send_name = TYPE_UNIVERSITY;
        }

        if (!is_null($enterprise_id) && is_null($university_id)) {
            $university_id = Auth::user()->university_id ?? abort(403);
            $user_send = TYPE_UNIVERSITY;
            $send_name = TYPE_ENTERPRISE;
        }

        $result = $this->collaborationRepository->updateCollaboration($university_id, $enterprise_id, $status, $send_name);

        if (!$result) return false;

        $data = [
            'title' => $status == APPROVED ? ACCEPT_COLLABORATION : REJECT_COLLABORATION,
            'message' => '',
            'type' => NOTIFY_FEEDBACK,
        ];

        return $this->createNotification($enterprise_id, $university_id, $data, $user_send);
    }

    public function destroyCollaboration(int $university_id = null, int $enterprise_id = null)
    {
        if (!is_null($university_id) && is_null($enterprise_id)) {
            $enterprise_id = Auth::user()->enterprise_id ?? abort(403);
            $user_send = TYPE_ENTERPRISE;
        }

        if (!is_null($enterprise_id) && is_null($university_id)) {
            $university_id = Auth::user()->university_id ?? abort(403);
            $user_send = TYPE_UNIVERSITY;
        }

        $result = $this->collaborationRepository->unSendCollaboration($university_id, $enterprise_id, $user_send);

        if (!$result) return false;

        return $this->deleteNotification($enterprise_id, $university_id, $user_send);
    }

    public function getCollaborationByUniversity(int $perPage, string $search)
    {
        $university_id = Auth::user()->university_id ?? abort(403);

        return $this->universityRepository->getCollaborationByUniversity($university_id, $perPage, $search);
    }

    private function getSenderAndReceiverIds(int $enterprise_id, int $university_id, string $user_send): ?array
    {
        $users_enterprise = $this->userEnterpriseRepository->getUserAdmin($enterprise_id)->pluck('id')->toArray();

        $users_university = $this->userUniversityRepository->getUserAdmin($university_id)->pluck('id')->toArray();

        if (!$users_enterprise || !$users_university) {
            return null;
        }

        if ($user_send === TYPE_ENTERPRISE) {
            return [$users_enterprise, $users_university];
        } elseif ($user_send === TYPE_UNIVERSITY) {
            return [$users_university, $users_enterprise];
        }

        return null;
    }
}
