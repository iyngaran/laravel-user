<?php

namespace Iyngaran\LaravelUser\Http\Controllers\Api;



use Iyngaran\LaravelUser\Repositories\RoleRepositoryInterface;
use Iyngaran\LaravelUser\Http\Requests\UserRole as UserRoleRequest;
use Iyngaran\LaravelUser\Http\Resources\Role as UserRoleResource;
use Iyngaran\LaravelUser\Http\Resources\RoleCollection;
use Iyngaran\LaravelUser\Actions\CreateRoleAction;
use Iyngaran\LaravelUser\Actions\UpdateRoleAction;
use Iyngaran\LaravelUser\Actions\DeleteRoleAction;
use Iyngaran\ApiResponse\Http\Traits\ApiResponse;
use Iyngaran\LaravelUser\DTOs\RoleData;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

class UserRoleController extends Controller
{
    use ApiResponse;

    private $role;

    public function __construct(RoleRepositoryInterface $_role_repository)
    {
        $this->role = $_role_repository;
    }

    public function index(): ?JsonResponse
    {
        return $this->responseWithCollection(
            new RoleCollection($this->role->all())
        );
    }


    public function store(UserRoleRequest $request): ?JsonResponse
    {
        return $this->createdResponse(
            new UserRoleResource((new CreateRoleAction())->execute(RoleData::fromRequest($request)))
        );
    }


    public function show($id)
    {
        return $this->responseWithItem(
            new UserRoleResource($this->role->find($id))
        );
    }


    public function update(UserRoleRequest $request, $id)
    {
        return $this->updatedResponse(
            new UserRoleResource((new UpdateRoleAction())->execute(RoleData::fromRequest($request), $id))
        );
    }


    public function destroy($id)
    {
        return $this->deletedResponse(
            (new DeleteRoleAction())->execute($id)
        );
    }
}
