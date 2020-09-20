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
                    'company_name' => $this->profile->company_name,
                    'address' => $this->profile->address,
                    'mobile' => $this->profile->mobile,
                    'phone' => $this->profile->phone,
                    'fb' => $this->profile->fb,
                    'in' => $this->profile->in,
                    'location_lat' => $this->profile->location_lat,
                    'location_lon' => $this->profile->location_lon,
                    'logo' => $this->profile->logo,
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
