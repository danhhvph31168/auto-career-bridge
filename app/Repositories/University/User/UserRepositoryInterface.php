<?php

namespace App\Repositories\University\User;

/**
 * Interface UserUniversityRepositoryInterface
 *
 * Defines the contract for interacting with the UserUniversity data source.
 */
interface UserRepositoryInterface
{
    /**
     * Get users of a specific university and role.
     *
     * @param int $universityId The ID of the university.
     * @param int $roleId The ID of the role.
     * @return \Illuminate\Database\Eloquent\Collection A collection of users matching the criteria.
     */
    public function getUniversityUsers(array $condition = [], int $perPage = 10);

    /**
     * Create a new user.
     *
     * @param array $data An associative array of user data.
     * @return \App\Models\User The newly created user model.
     */
    public function create(array $data);

    public function createManyUsers(array $data);
    
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

    /**
     * Delete a user by their ID.
     *
     * @param int $id The ID of the user to delete.
     * @return bool True if the deletion was successful, otherwise False.
     */
    public function destroy($id);
}
