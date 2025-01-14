<?php

namespace App\Services\Enterprise;

use App\Repositories\Enterprises\EnterpriseRepositoryInterface;
use Illuminate\Support\Facades\Auth;

class EnterpriseService
{
    public function __construct(protected EnterpriseRepositoryInterface $enterpriseRepository) {}

    public function getAllEnterprises($request)
    {
        $perPage = $request['perPage'] ?? 10;

        $search['province'] = $request['province'] ?? '';

        $search['keyword'] = $request['keyword'] ?? '';

        return $this->enterpriseRepository->getAllEnterprisesPaginate($perPage, $search);
    }

    public function getBySlug(string $slug)
    {
        $enterprise =  $this->enterpriseRepository->getBySlug($slug);

        if (!$enterprise) {
            abort(404);
        }

        if (Auth::check() && Auth::user()->university_id) {
            $enterprise->load(['universities' => function ($query) {
                $query->wherePivot('university_id', Auth::user()->university_id);
                    // ->wherePivot('send_name', TYPE_UNIVERSITY);
            }]);

            $enterprise->has_collaboration = $enterprise->universities->first()?->pivot;
        }

        return $enterprise;
    }
}
