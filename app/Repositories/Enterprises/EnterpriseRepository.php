<?php

namespace App\Repositories\Enterprises;

use App\Models\Enterprise;
use App\Repositories\BaseRepository;

class EnterpriseRepository extends BaseRepository implements EnterpriseRepositoryInterface
{
    public function getModel()
    {
        return Enterprise::class;
    }

    public function getTopApplies(int $limit, int $perPage)
    {
        return $this->_model
            ->with(['users' => function ($query) {
                $query->where('role_id', ROLE_ADMIN);
            }])
            ->withSum('jobs', 'applicants')
            ->having('jobs_sum_applicants', '>', 0)
            ->orderByDesc('jobs_sum_applicants')
            ->take($limit)
            ->paginate($perPage);
    }

    public function getAllEnterprisesPaginate(int $perPage, array $search)
    {
        $query = $this->_model::where('is_verify', IS_ACTIVE);

        if (!empty($search['province'])) {
            $query->where('address', 'LIKE', '%' . $search['province'] . '%');
        }

        if (!empty($search['keyword'])) {
            $query->where(function ($query) use ($search) {
                $query->where('name', 'LIKE', '%' . $search['keyword'] . '%')
                    ->orWhere('industry', 'LIKE', '%' . $search['keyword'] . '%')
                    ->orWhere('size', 'LIKE', '%' . $search['keyword'] . '%')
                    ->orWhere('email', 'LIKE', '%' . $search['keyword'] . '%');
            });
        }

        return $query->paginate($perPage);
    }

    public function getBySlug(string $slug)
    {
        return $this->_model::where('slug', $slug)
            ->where('is_verify', IS_ACTIVE)
            ->first();
    }

    public function getById(int $id)
    {
        return $this->_model->where('id', $id)
            ->where('is_verify', IS_ACTIVE)
            ->first();
    }

    public function getCollaborationByEnterprise(int $enterprise_id, int $perPage, string $search)
    {
        $enterprise = $this->findById($enterprise_id);

        if (!$enterprise) {
            return null;
        }

        $query = $enterprise->universities()
            ->orderBy('collaborations.status');

        if ($search) {
            $query->where(function ($query) use ($search) {
                $query->where('name', 'LIKE', '%' . $search . '%');
            });
        }

        return $query->paginate($perPage)->withQueryString();
    }
}
