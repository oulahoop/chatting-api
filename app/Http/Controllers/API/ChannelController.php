<?php

namespace App\Http\Controllers\API;

use App\Models\Channel;
use App\Models\Server;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ChannelController extends BaseController
{
    //
    public function store(Request $request): JsonResponse {
        $input = $request->all();
        $currentUser = auth()->user();

        $server = Server::find($input['server_id']);

        if ($server->owner_id != $currentUser->id) {
            return $this->sendError('You are not the owner of this server.');
        }

        $channel = new Channel();
        $channel->name = $input['name'];
        $channel->server_id = $input['server_id'];
        $channel->save();

        return $this->sendResponse($channel, 'Channel created successfully.');
    }
}
