<?php

namespace App\Repositories\University\Workshop;

use App\Models\Enterprise;
use App\Models\Workshop;

interface WorkShopRepositoryInterface
{
    /**
     * Get users of a specific university and role.
     *
     * @param int $universityId The ID of the university.
     * @param int $roleId The ID of the role.
     * @return \Illuminate\Database\Eloquent\Collection A collection of users matching the criteria.
     */
    public function getWorkShop(array $condition = [], int $perPage = 10);

    /**
     * Create a new user.
     *
     * @param array $data An associative array of user data.
     * @return \App\Models\User The newly created user model.
     */
    public function create(array $data);

    /**
     * Find a user by their ID.
     *
     * @param int $id The ID of the user.
     * @return \App\Models\User|null The user model if found, or null if not.
     */
    public function findById($id);

    /**
     * Update a user's data.
     *
     * @param int $id The ID of the user to update.
     * @param array $data An associative array of the updated data.
     * @return bool True if the update was successful, otherwise False.
     */
    public function update($id, array $data);

    public function updateApplyStatus(int $status, Workshop $workshop, Enterprise $enterprise);

    /**
     * Delete a user by their ID.
     *
     * @param int $id The ID of the user to delete.
     * @return bool True if the deletion was successful, otherwise False.
     */
    public function destroy($id);

    public function countAccept();

    public function sumApplicants(int $year);

    public function countApply(int $status, int $year);

    public function  countApplyByMonth(int $status, int $year);

    public function checkJoinExists($enterprise, $workshopId);

    public function checkJoinSuccess($enterprise, $workshopId);

    public function checkJoinRefuse($enterprise, $workshopId);

    public function getAdminUser($workshopId);

    public function getIdWorkshopEnterprise($workshopId, $enterpriseId);
}
