<?php

namespace App\Repositories\Admin\Job;

use App\Models\Job;
use App\Repositories\BaseRepository;


class JobRepository extends BaseRepository implements JobRepositoryInterface
{
    public function getModel()
    {
        return Job::class;
    }

    public function getAllJob(int $perPage, array $search)
    {
        $query = $this->_model->with(['enterprises', 'major']);

        $validStatuses = [
            'pending' => PENDING_APPROVE,
            'approved' => APPROVED,
            'reject' => UN_APPROVE,
        ];

        $status = $search['status'] ?? '';

        if ($status !== '' && array_key_exists($status, $validStatuses)) {
            $status = $validStatuses[$status];
            $query->where('status', $status);
        }


        if (!empty($search['q'])) {
            $keyword = $search['q'];
            $query->where(function ($q) use ($keyword) {
                $q->where('title', 'like', '%' . $keyword . '%')
                    ->orWhereHas('enterprises', function ($q) use ($keyword) {
                        $q->where('name', 'like', '%' . $keyword . '%');
                    })
                    ->orWhereHas('major', function ($q) use ($keyword) {
                        $q->where('name', 'like', '%' . $keyword . '%');
                    });
            });
        }

        return $query
            ->orderBy('status')
            ->paginate($perPage);
    }


    public function findById($id, array $column = ['*'])
    {
        return $this->_model
            ->with(['enterprises', 'major'])
            ->findOrFail($id);
    }
}
