<?php

namespace Iyngaran\LaravelUser\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class User extends JsonResource
{
    public function toArray($request)
    {
        return [
            'data' => [
                'type' => 'user',
                'user_id' => $this->id,
                'attributes' => [
                    'id' => $this->id,
                    'name' => $this->name,
                    'email' => $this->email,
                    'company_name' => $this->company_name,
                    'address' => $this->address,
                    'mobile' => $this->mobile,
                    'phone' => $this->phone,
                    'fb' => $this->fb,
                    'in' => $this->in,
                    'location_lat' => $this->location_lat,
                    'location_lon' => $this->location_lon,
                    'logo' => $this->logo,
                    'roles' => new RoleCollection($this->roles),
                    'extra_permissions' => new PermissionCollection($this->getDirectPermissions()),
                    'created_at' => $this->created_at,
                    'updated_at' => $this->updated_at
                ],
                'links' => [
                    'self' => url("api/users/" . $this->id),
                ]
            ]
        ];
    }
}
