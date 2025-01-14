<?php

namespace App\Services;

use App\Repositories\Enterprises\EnterpriseRepositoryInterface;

class EnterpriseService
{
    public function __construct(protected EnterpriseRepositoryInterface $enterpriseRepository) {}

    public function getDashboardData()
    {
        $countAll = $this->enterpriseRepository->countAll();

        $getTopApplies = $this->enterpriseRepository->getTopApplies(10, 5);

        // dd($getTopApplies);

        return [
            'countAll' => $countAll,
            'getTopApplies' => $getTopApplies,
        ];
    }
}
