<?php

namespace App\Repositories\SubAdmin;

interface SubAdminRepositoryInterface
{
    public function getSubAdmin(array $condition = [], int $perPage = 10);
    public function create(array $data);
    public function findById($id);
    public function update($id, array $data);
    public function destroy($id);
}
