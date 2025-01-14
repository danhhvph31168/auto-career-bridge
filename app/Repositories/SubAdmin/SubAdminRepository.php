<?php

namespace App\Repositories\SubAdmin;

use App\Models\User;
use App\Repositories\BaseRepository;

class SubAdminRepository extends BaseRepository implements SubAdminRepositoryInterface
{
    /**
     * Return the corresponding model.
     *
     * @return string The class name of the model.
     */
    public function getModel()
    {
        return User::class;
    }

    /**
     * Retrieve a paginated list of SubAdmins based on the specified conditions.
     *
     * @param array $condition An associative array containing query conditions.
     *     - 'role_id': int|null Role ID for filtering.
     *     - 'q': string|null Search keyword for username, email, or phone.
     * @param int $perPage The number of results per page (default: 10).
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator Paginated list of SubAdmins.
     */
    public function getSubAdmin(array $condition = [], int $perPage = 10)
    {
        // Initialize the query on the User model
        $query = $this->getModel()::query();

        // Apply filtering by role ID
        if (isset($condition['role_id'])) {
            $query->where('role_id', $condition['role_id']);
        }

        // Ensure the SubAdmin is not associated with a university, enterprise, or specific user type

        $query->whereNull('user_type')
            ->orWhere('user_type', '')
            ->whereNull('university_id')
            ->whereNull('enterprise_id');


        // Exclude soft-deleted records
        $query->withoutTrashed();

        // Apply search filter
        if (!empty($condition['q'])) {
            $query->where(function ($q) use ($condition) {
                $q->where('username', 'like', '%' . $condition['q'] . '%')
                    ->orWhere('email', 'like', '%' . $condition['q'] . '%')
                    ->orWhere('phone', 'like', '%' . $condition['q'] . '%');
            });
        }

        // Sort the results by ID in descending order
        $query->orderBy('id', 'desc');

        // Return the paginated results
        return $query->paginate($perPage)->withQueryString();
    }
}
