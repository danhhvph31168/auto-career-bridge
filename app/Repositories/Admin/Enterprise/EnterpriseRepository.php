<?php

namespace App\Repositories\Admin\Enterprise;

use App\Models\User;
use App\Repositories\BaseRepository;

/**
 * Class EnterpriseRepository
 * @package App\Repositories\Admin\Enterprise
 */
class EnterpriseRepository extends BaseRepository implements EnterpriseRepositoryInterface
{
    /**
     * Get the model associated with the repository.
     *
     * @return string
     */
    public function getModel()
    {
        return User::class;
    }

    /**
     * Retrieve a paginated list of enterprises with optional search filters.
     *
     * @param int $perPage
     * @param array $search
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getAllEnterprise(int $perPage, array $search)
    {
        $query = $this->_model
            ->where('user_type', 'enterprise')
            ->where('role_id', ROLE_ADMIN)
            ->join('enterprises', 'users.enterprise_id', '=', 'enterprises.id')
            ->select('users.*', 'enterprises.name as enterprise_name')
            ->whereNotNull('enterprise_id')
            ->orderBy('users.created_at', 'desc');

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
                $q->where('users.email', 'like', '%' . $keyword . '%')
                    ->orWhere('username', 'like', '%' . $keyword . '%')
                    ->orWhere('users.phone', 'like', '%' . $keyword . '%')
                    ->orWhere('enterprises.name', 'like', '%' . $keyword . '%');
            });
        }

        return $query->paginate($perPage)->withQueryString();
    }

    /**
     * Find an enterprise by its ID with additional columns and relations.
     *
     * @param int $id
     * @param array $column
     * @return \App\Models\User
     */
    public function findById($id, array $column = ['*'])
    {
        return $this->_model
            ->with('enterprise')
            ->findOrFail($id);
    }
}
