<?php

namespace App\Services\Client;

use App\Models\University;
use App\Repositories\University\UniversityRepositoryInterface;

class UniversityService
{
    public function __construct(protected UniversityRepositoryInterface $universityRepository) {}

    /**
     * call back query in repository then use for to add value of quantity of cooperation to return view
     * @param mixed $filters
     * @param mixed $perPage
     *
     * @return [$universities]
     */
    public function listUniversities($filters, $perPage)
    {
        $universities = $this->universityRepository->getUniversities($filters, $perPage);

        foreach ($universities as $university) {
            $university->numberCooperate = $this->universityRepository->getNumberCooperate($university->id);
        }

        return $universities;
    }

    public function getDashboardData()
    {
        $countAll = $this->universityRepository->countAll();

        return [
            'countAll' => $countAll,
        ];
    }

    public function sendCollaboration(int $university_id)
    {
        $university = $this->universityRepository->findById($university_id);

        if (!$university) {
            $university->cooperate = true;
            $this->universityRepository->save($university);
        }
    }
}
