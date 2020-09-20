<?php


namespace Iyngaran\LaravelUser\DTOs;


use Spatie\DataTransferObject\DataTransferObject;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;


class UserData extends DataTransferObject
{
    /**
     * @var string
     */
    public $name;

    /**
     * @var string|null
     */
    public $email;

    /**
     * @var string|null
     */
    public $password;

    /**
     * @var string|null
     */
    public $companyName;

    /**
     * @var string|null
     */
    public $address;

    /**
     * @var string|null
     */
    public $mobile;

    /**
     * @var string|null
     */
    public $phone;

    /**
     * @var string|null
     */
    public $fb;

    /**
     * @var string|null
     */
    public $in;

    /**
     * @var double|null
     */
    public $locationLat;

    /**
     * @var double|null
     */
    public $locationLon;

    /**
     * @var string|null
     */
    public $logo;

    /**
     * @var \Spatie\Permission\Models\Role[]
     */
    public $roles;

    /**
     * @var \Spatie\Permission\Models\Permission[]
     */
    public $extraPermissions;

    public static function fromRequest(Request $request): array
    {
        $roles = [];
        if ($role_ids = $request->input('role_ids')) {
            $roles = Role::whereIn('id', $role_ids)->get();
        }

        $extraPermissions = [];
        if ($extra_permission_ids = $request->input('extra_permission_ids')) {
            $extraPermissions = Permission::whereIn('id', $extra_permission_ids)->get();
        }

        return (new self(
            [
                'name' => ucfirst($request->input('name')),
                'email' => $request->input('email'),
                'password' => $request->input('password'),
                'companyName' => $request->input('company_name'),
                'address' => $request->input('address'),
                'mobile' => $request->input('mobile'),
                'phone' => $request->input('phone'),
                'fb' => $request->input('fb'),
                'in' => $request->input('in'),
                'locationLat' => (double)$request->input('location_lat'),
                'locationLon' => (double)$request->input('location_lon'),
                'logo' => $request->input('logo'),
                'roles' => $roles,
                'extraPermissions' => $extraPermissions
            ]
        )
        )->toArray();
    }

}
