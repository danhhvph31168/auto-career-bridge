<?php

namespace App\Repositories\Auth;

/**
 * Interface RegisterRepositoryInterface
 *
 * Defines the contract for interacting with the RegisterRepository data source.
 */

interface RegisterRepositoryInterface
{
    /**
     * Create a new user.
     *
     * @param array $data An associative array of user data.
     * @return \App\Models\User The newly created user model.
     */

    public function create(array $data);
}
