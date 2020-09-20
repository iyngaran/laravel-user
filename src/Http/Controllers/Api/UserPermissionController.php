<?php

namespace Iyngaran\LaravelUser\Http\Controllers\Api;


use Iyngaran\LaravelUser\Repositories\PermissionRepositoryInterface;
use Iyngaran\LaravelUser\Http\Resources\PermissionCollection;
use Iyngaran\LaravelUser\Http\Requests\UserPermission;
use Iyngaran\LaravelUser\Actions\CreatePermissionAction;
use Iyngaran\LaravelUser\Actions\UpdatePermissionAction;
use Iyngaran\LaravelUser\Actions\DeletePermissionAction;
use Iyngaran\LaravelUser\Http\Resources\Permission;
use Iyngaran\ApiResponse\Http\Traits\ApiResponse;
use Iyngaran\LaravelUser\DTOs\PermissionData;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

class UserPermissionController extends Controller
{
    use ApiResponse;

    private $permissions;

    public function __construct(PermissionRepositoryInterface $_permission_repository)
    {
        $this->permissions = $_permission_repository;
    }


    public function index(): ?JsonResponse
    {
        return $this->responseWithCollection(
            new PermissionCollection($this->permissions->all())
        );
    }


    public function store(UserPermission $request): ?JsonResponse
    {
        return $this->createdResponse(
            new Permission((new CreatePermissionAction())->execute(PermissionData::fromRequest($request)))
        );
    }


    public function show($id)
    {
        return $this->responseWithItem(
            new Permission($this->permissions->find($id))
        );
    }


    public function update(UserPermission $request, $id)
    {
        return $this->updatedResponse(
            new Permission((new UpdatePermissionAction())->execute(PermissionData::fromRequest($request), $id))
        );
    }


    public function destroy($id)
    {
        return $this->deletedResponse(
            (new DeletePermissionAction())->execute($id)
        );
    }
}
