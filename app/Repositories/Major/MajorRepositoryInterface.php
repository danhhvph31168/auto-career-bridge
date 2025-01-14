<?php

namespace App\Repositories\Major;

interface MajorRepositoryInterface
{
    /**
     * Get all major
     *
     * @param array $column
     *
     * @return [type]
     */
    public function getAll(array $column = ['*']);

    /**
     * Get all major of the university
     *
     * @param array $condition
     *
     * @return [type]
     */
    public function getMajorUniversity(array $condition = ['*'], int $perPage = 10);

    public function getMajorUniversityApproved(array $condition = ['*']);

    public function create(array $data);

    public function update($id, array $data);

    public function findById($id);

    public function destroy($id);
}
