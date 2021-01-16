<?php

namespace Iyngaran\LaravelUser\Http\Controllers\Api;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
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

    public function uploadProfilePicture(Request $request)
    {
        try {
            $file = $request->file('file');
            $userId = $request->input('user-id');
            $file_name = date('Ymdhis') . "_" . trim(str_replace(" ", "_", $file->getClientOriginalName()));
            Storage::disk('user-profile-images')->put($file_name, File::get($file));
        } catch (\Exception $e) {
            return response(['errors' => ['message' => $e->getMessage()]], 404);
        }

        $userModel = config('iyngaran.user.user_model');
        $userModel::find($userId)->update(
            [
                'profile_pic' => $file_name
            ]
        );
        $user = $userModel::find($userId);
        return response()->json(
            [
                'user' => $user,
                'message' => 'Successfully updated the profile picture!'
            ],
            200
        );
    }

}
