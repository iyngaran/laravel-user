<?php


namespace Iyngaran\LaravelUser\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Role extends JsonResource
{
    public function toArray($request)
    {
        return [
            'data' => [
                'type' => 'user-role',
                'role_id' => $this->id,
                'attributes' => [
                    'id' => $this->id,
                    'name' => $this->name,
                    'permissions' => new PermissionCollection($this->permissions),
                    'created_at' => $this->created_at,
                    'updated_at' => $this->updated_at
                ],
                'links' => [
                    'self' => url("api/user-roles/" . $this->id),
                ]
            ]
        ];
    }
}
