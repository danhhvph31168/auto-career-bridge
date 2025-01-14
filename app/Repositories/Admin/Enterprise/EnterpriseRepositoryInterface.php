<?php

namespace App\Repositories\Admin\Enterprise;

interface EnterpriseRepositoryInterface
{
    // getAll list account admin enterprise
    public function create(array $data);

    public function getAllEnterprise(int $perPage, array $search);

    // handle find account
    public function findById($id);

    // handle approve account
    public function update($id, array $data);

    // handle delete account
    public function destroy($id);

}
