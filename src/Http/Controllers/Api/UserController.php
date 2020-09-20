<?php

namespace Iyngaran\LaravelUser\Http\Controllers\Api;



use Iyngaran\LaravelUser\Http\Resources\User as UserResource;
use Iyngaran\LaravelUser\Http\Requests\User as UserRequest;
use Iyngaran\LaravelUser\Repositories\UserRepositoryInterface;
use Iyngaran\LaravelUser\Http\Resources\UserCollection;
use Iyngaran\LaravelUser\Http\Requests\UserUpdate;
use Iyngaran\LaravelUser\Actions\CreateUserAction;
use Iyngaran\LaravelUser\Actions\UpdateUserAction;
use Iyngaran\LaravelUser\Actions\DeleteUserAction;
use Iyngaran\ApiResponse\Http\Traits\ApiResponse;
use App\Http\Controllers\Controller;
use Iyngaran\LaravelUser\DTOs\UserData;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{
    use ApiResponse;

    private $user;

    public function __construct(UserRepositoryInterface $_user_repository)
    {
        $this->user = $_user_repository;
    }

    public function index(): ?JsonResponse
    {
        return $this->responseWithCollection(
            new UserCollection($this->user->all())
        );
    }

    public function store(UserRequest $request): ?JsonResponse
    {
        return $this->createdResponse(
            new UserResource((new CreateUserAction())->execute(UserData::fromRequest($request)))
        );
    }

    public function show($id)
    {
        return $this->responseWithItem(
            new UserResource($this->user->find($id))
        );
    }

    public function update(UserUpdate $request, $id)
    {
        return $this->updatedResponse(
            new UserResource((new UpdateUserAction())->execute(UserData::fromRequest($request), $id))
        );
    }

    public function destroy($id)
    {
        return $this->deletedResponse(
            (new DeleteUserAction())->execute($id)
        );
    }
}
