<?php

namespace App\Repositories\Enterprises;

interface EnterpriseRepositoryInterface
{

    public function getAll();

    public function create(array $data);

    public function update($id, array $data);

    public function getTopApplies(int $limit, int $perPage);

    public function getAllEnterprisesPaginate(int $perPage, array $search);

    public function getBySlug(string $slug);

    public function getById(int $id);

    public function getCollaborationByEnterprise(int $enterprise_id, int $perPage, string $search);
}
