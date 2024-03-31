<?php

namespace App\Http\Controllers\API;

use App\Http\Resources\ServerResource;
use App\Models\Server;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ServerController extends BaseController
{
    public function store(Request $request): JsonResponse {
        $input = $request->all();
        $currentUser = auth()->user();

        $server = new Server();
        $server->name = $input['name'];
        $server->owner_id = $currentUser->id;
        $server->image_url = $input['image_url'] ?? 'temp';
        $server->save();

        $server->users()->attach($currentUser->id);

        $server->load('users');
        $server->load('channels');

        return $this->sendResponse($server, 'Server created successfully.');
    }
}
