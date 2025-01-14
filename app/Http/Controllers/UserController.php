<?php

namespace App\Http\Controllers;

use App\Repositories\Users\UserRepositoryInterface;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function getAll()
    {
        dd($this->userRepository->getAll());
    }
}
