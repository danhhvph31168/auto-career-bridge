<?php

namespace App\Services;

use App\Repositories\Major\MajorRepositoryInterface;

class MajorService
{
    public function __construct(protected MajorRepositoryInterface $majorRepository) {}

    public function getAllMajors()
    {
        return $this->majorRepository->getAll(['id', 'name']);
    }
}
