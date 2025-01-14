<?php

namespace App\Repositories\Users;

interface UserRepositoryInterface
{
    public function getAll(array $column = ['*']);
    public function findById($id, array $column = ['*']);
    public function getUniversityAccount(array $condition = [], array $column = ['*']);
    public function update($id, array $data);
    public function destroy($id);
    public function getUserAdminUniversity(int $university_id);

    public function getUserSupperAdmin();
}
