<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\MessageResource;
use App\Models\Message;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Server;

class MessageController extends BaseController
{
    public function index(): JsonResponse
    {
        $users = User::all();
        $serverToAdd = Server::find(4);
        foreach ($users as $user) {
            $user->servers()->attach($serverToAdd->id);
        }

        return $this->sendResponse($users, 'Users retrieved successfully.');

        //$messages = Message::all();

        //return $this->sendResponse(MessageResource::collection($messages), 'Messages retrieved successfully.');
    }

    public function store(Request $request): JsonResponse
    {
        $input = $request->all();
        $currentUser = auth()->user();

        $message = new Message();
        $message->content = $input['content'];
        $message->creator_id = $currentUser->id;
        $message->channel_id = array_key_exists('channel_id', $input) ? $input['channel_id'] : null;
        $message->user_id_to = array_key_exists('user_id_to', $input) ? $input['user_id_to'] : null;
        $message->save();

        return $this->sendResponse(new MessageResource($message), 'Message created successfully.');
    }


    public function getMessageWith(Request $request): JsonResponse
    {
        $user = auth()->user();
        $user_id_to = $request->user_id_to;
        $messagesFromCurrentUser = $user->messages()->where('user_id_to', $user_id_to)->get();
        $messagesFromOtherUser = Message::where('user_id_to', $user->id)->where('creator_id', $user_id_to)->get();

        $messages = $messagesFromCurrentUser->merge($messagesFromOtherUser)->sortBy('created_at');

        return $this->sendResponse(MessageResource::collection($messages), 'Messages retrieved successfully.');
    }

    public function getChannelMessage(Request $request): JsonResponse {
        $channel_id = $request->channel_id;
        $messages = Message::where('channel_id', $channel_id)->get();
        return $this->sendResponse(MessageResource::collection($messages), 'Messages retrieved successfully.');
    }
}
