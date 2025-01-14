<?php

namespace App\Repositories\Admin\Job;

interface JobRepositoryInterface
{
    public function getAllJob(int $perPage, array $search);

    public function findById($id);

    public function update($id, array $data);

    public function destroy($id);
}
