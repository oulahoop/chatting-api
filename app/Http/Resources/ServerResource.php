<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ServerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Server $server): array
    {
        return [
            'id' => $request->id,
            'name' => $request->name,
            'owner' => $request->owner,
        ];
    }
}
