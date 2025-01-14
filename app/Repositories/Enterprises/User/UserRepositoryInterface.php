<?php

namespace App\Repositories\Enterprises\User;

interface UserRepositoryInterface
{
    public function getAllUsersPaginate(int $perPage, string $search);

    public function findByEmail(string $email);

    public function findByPhone(string $phone);

    public function createManyUsers(array $data);

    public function getUserAdmin(int $enterprise_id);
}