<?php

namespace App\Repositories\Auth;

use App\Repositories\BaseRepository;
use App\Models\User;

class RegisterRepository extends BaseRepository implements RegisterRepositoryInterface
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
}
