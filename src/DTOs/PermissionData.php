<?php

namespace Iyngaran\LaravelUser\DTOs;

use Spatie\DataTransferObject\DataTransferObject;
use Illuminate\Http\Request;

class PermissionData extends DataTransferObject
{
    /**
     * @var string
     */
    public $name;

    public static function fromRequest(Request $request): array
    {
        return (new self(
            [
                'name' => ucfirst($request->input('name'))
            ]
        ))->toArray();
    }
}
