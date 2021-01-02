<?php

namespace Iyngaran\LaravelUser\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Carbon;
use Iyngaran\ApiResponse\Http\Traits\ApiResponse;
use Iyngaran\LaravelUser\Actions\CreateUserAction;
use Iyngaran\LaravelUser\DTOs\UserData;
use Iyngaran\LaravelUser\Http\Requests\RegisterRequest;
use Iyngaran\LaravelUser\Http\Resources\User as UserResource;
use Spatie\Permission\Models\Role;

class RegisterController extends Controller
{
    use ApiResponse;
    private $defaultRoles = [];

    public function __construct()
    {
        $role = Role::where('name', config('iyngaran.user.default_role'))->first();
        $role_ids = [];
        if ($role) {
            $role_ids[] = $role->id;
        }
        $this->defaultRoles = $role_ids;
    }


    public function register(RegisterRequest $request)
    {
        $request->only(
            [
                'name',
                'last_name',
                'email',
                'password',
                'company_name',
                'address',
                'mobile',
                'phone',
                'logo',
                'fb',
                'in',
                'location_lat',
                'location_lon'
            ]
        );
        $request->merge(['role_ids' => $this->defaultRoles, 'password_change_at' => Carbon::now()->toDateTimeString()]);
        return $this->createdResponse(
            new UserResource((new CreateUserAction())->execute(UserData::fromRequest($request)))
        );
    }
}
