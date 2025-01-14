<?php

namespace App\Repositories\Collaboration;

use App\Models\Collaboration;
use App\Repositories\BaseRepository;

class CollaborationRepository extends BaseRepository implements CollaborationRepositoryInterface
{
    public function getModel()
    {
        return Collaboration::class;
    }

    public function findByUniversityAndEnterprise(int $university_id, int $enterprise_id, string $send_name = null)
    {
        $query = $this->_model
            ->where('university_id', $university_id)
            ->where('enterprise_id', $enterprise_id);

        if (!is_null($send_name)) {
            $query->where('send_name', $send_name);
        }

        return $query->first();
    }

    public function unSendCollaboration(int $university_id, int $enterprise_id, string $send_name = null)
    {
        $query = $this->_model
            ->where('university_id', $university_id)
            ->where('enterprise_id', $enterprise_id)
            ->where('status', PENDING_APPROVE);

        if (!is_null($send_name)) {
            $query->where('send_name', $send_name);
        }

        return $query->delete();
    }

    public function updateCollaboration(int $university_id, int $enterprise_id, int $status, string $send_name)
    {
        $collaboration = $this->findByUniversityAndEnterprise($university_id, $enterprise_id,  $send_name);

        if (!$collaboration) return false;

        return $collaboration->update([
            'status' => $status,
        ]);
    }
}
