<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends BaseController
{
    //

    public function index(): JsonResponse
    {
        $users = User::all();

        return $this->sendResponse($users, 'Users retrieved successfully.');
    }

    public function me(): JsonResponse
    {
        $user = auth()->user();
        $servers = $user->servers()->get();
        //$channels = $servers->channels()->get();

        $response = [
            'user' => $user,
            'servers' => $servers,
            /*'channels' => $channels*/
        ];

        return $this->sendResponse($response, 'User retrieved successfully.');
    }
}
