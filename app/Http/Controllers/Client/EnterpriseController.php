<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Services\Enterprise\EnterpriseService;
use App\Services\MajorService;
use Illuminate\Http\Request;

class EnterpriseController extends Controller
{
    const PATH_VIEW = 'client.enterprise.';

    public function __construct(
        protected EnterpriseService $enterpriseService,
        protected MajorService $majorService
    ) {}

    public function index(Request $request)
    {
        $enterprises = $this->enterpriseService->getAllEnterprises($request->all());

        if ($request->wantsJson()) {
            return response()->json($enterprises);
        }

        return view(self::PATH_VIEW . __FUNCTION__, compact('enterprises'));
    }

    public function show(string $slug)
    {
        $enterprise = $this->enterpriseService->getBySlug($slug);

        return view(self::PATH_VIEW . __FUNCTION__, compact('enterprise'));
    }
}
