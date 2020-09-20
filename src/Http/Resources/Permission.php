<?php

namespace Iyngaran\LaravelUser\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Permission extends JsonResource
{

    public function toArray($request)
    {
        return [
            'data' => [
                'type' => 'user-permissions',
                'permission_id' => $this->id,
                'attributes' => [
                    'id' => $this->id,
                    'name' => $this->name,
                    'created_at' => $this->created_at,
                    'updated_at' => $this->updated_at
                ],
                'links' => [
                    'self' => url("api/user-permissions/" . $this->id),
                ]
            ]
        ];
    }
}
