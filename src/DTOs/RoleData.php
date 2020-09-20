<?php

namespace Iyngaran\LaravelUser\DTOs;

use Spatie\DataTransferObject\DataTransferObject;
use Spatie\Permission\Models\Permission;
use Illuminate\Http\Request;


class RoleData extends DataTransferObject
{
    /**
     * @var string
     */
    public $name;

    /**
     * @var \Spatie\Permission\Models\Permission[]
     */
    public $permissions;

    public static function fromRequest(Request $request): array
    {
        $permissions = [];
        if ($permission_ids = $request->input('permission_ids')) {
            $permissions = Permission::whereIn('id', $permission_ids)->get();
        }

        return (new self(
            [
                'name' => ucfirst($request->input('name')),
                'permissions' => $permissions
            ]
        ))->toArray();
    }

}
