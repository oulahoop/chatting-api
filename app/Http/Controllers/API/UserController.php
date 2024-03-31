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
        $user->load('servers');
        //load channels of servers
        $servers = $user->servers;
        foreach ($servers as $server) {
            $server->load('channels');
        }


        //$channels = $servers->channels()->get();

    
        return $this->sendResponse($user, 'User retrieved successfully.');
    }
}
