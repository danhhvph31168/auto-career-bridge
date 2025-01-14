<?php

namespace App\Http\Controllers\Client;

use App\Services\Client\HomeService;

class HomeController {
    protected $homeService;
    
    public function __construct(HomeService $homeService)
    {
        $this->homeService = $homeService;
    }

    public function index (){
        $template = 'client.layouts.home';

        $status = $this->homeService->getJobAndCompanyStats();
        
        return view($template, compact('status'));
    }
}