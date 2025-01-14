<?php

namespace App\Repositories\Collaboration;

interface CollaborationRepositoryInterface
{
    public function findByUniversityAndEnterprise(int $university_id, int $enterprise_id, string $send_name = null);

    public function unSendCollaboration(int $university_id, int $enterprise_id, string $send_name = null);

    public function updateCollaboration(int $university_id, int $enterprise_id, int $status, string $send_name);
}
