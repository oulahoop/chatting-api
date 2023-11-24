<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\ServerResource;
use App\Models\Server;
use Illuminate\Http\Client\Request;
use Illuminate\Http\JsonResponse;

class ServerController extends Controller
{
    public function store(Request $request): JsonResponse {
        $input = $request->all();
        $currentUser = auth()->user();

        $server = new Server();
        $server->name = $input['name'];
        $server->owner_id = $currentUser->id;
        $server->save();

        return $this->sendResponse(new ServerResource($server), 'Server created successfully.');
    }
}
