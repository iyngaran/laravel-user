<?php

namespace Iyngaran\LaravelUser\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Iyngaran\ApiResponse\Http\Traits\ApiResponse;
use Iyngaran\LaravelUser\Repositories\UserRepositoryInterface;
use Illuminate\Http\Resources\Json\JsonResource;
use Iyngaran\LaravelUser\Http\Resources\AuthenticatedUser as UserResource;
use Iyngaran\LaravelUser\Http\Requests\LoginRequest;

class AuthController extends Controller
{
    use ApiResponse;

    private $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function login(LoginRequest $request)
    {
        $loginData = $request->only(['email', 'password']);
        if (!auth()->attempt($loginData)) {
            return $this->unauthorizedAccess(new JsonResource(['message' => 'Invalid Credentials']));
        }

        if (!auth()->user()->hasVerifiedEmail() || !auth()->user()->password_change_at) {
            return $this->unauthorizedAccess(new JsonResource(['message' => 'Your account has not been verified.']));
        }

        $accessToken = auth()->user()->createToken($request->input('device_name'))->plainTextToken;
        $user = $this->userRepository->findWithRolesAndPermissions(auth()->user()->id);
        return $this->responseWithItem(
            new UserResource(
                [
                    'user' => $user,
                    'token' => $accessToken
                ]
            )
        );
    }
}
