<?php

namespace App\Repositories;

interface BaseRepositoryInterface
{
    public function getAll();
    public function create(array $data);
    public function findById($id);
    public function update($id, array $data);
    public function destroy($id);
}
