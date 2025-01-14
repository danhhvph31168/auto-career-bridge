<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Repositories\University\Workshop\WorkShopRepositoryInterface;
use App\Services\Client\WorkshopService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WorkshopController extends Controller
{
    const PATH_VIEW = 'client.workshops.index';
    protected $workshopRepository;
    protected $workshopService;

    public function __construct(
        WorkShopRepositoryInterface $workshopRepository,
        WorkshopService $workshopService
    ) {
        $this->workshopRepository = $workshopRepository;
        $this->workshopService = $workshopService;
    }

    public function index()
    {
        $config = config('apps.clients.workshops');

        return view(self::PATH_VIEW, [
            'config' => $config
        ]);
    }

    public function detail($id)
    {
        $workshop = $this->workshopRepository->findById($id);
        if (!isset($workshop) && empty($workshop)) {

            return abort(404);
        }
        $config = config('apps.clients.workshops');
        $university = $workshop->university;

        if (!empty(Auth::user()->enterprise)) {
            $checkJoin = $this->workshopRepository->checkJoinExists(Auth::user()->enterprise, $workshop->id);
            $checkJoinSuccess = $this->workshopRepository->checkJoinSuccess(Auth::user()->enterprise, $workshop->id);
            $checkJoinRefuse = $this->workshopRepository->checkJoinRefuse(Auth::user()->enterprise, $workshop->id);
        } else {
            $checkJoin = false;
            $checkJoinSuccess = false;
            $checkJoinRefuse = false;
        }

        return view(self::PATH_VIEW, [
            'workshop' => $workshop,
            'university' => $university,
            'config' => $config,
            'checkJoin' => $checkJoin,
            'checkJoinSuccess' => $checkJoinSuccess,
            'checkJoinRefuse' => $checkJoinRefuse,
        ]);
    }

    public function apply()
    {
        $result = $this->workshopService->join();

        return back()->with($result['status'], $result['message']);
    }
}
