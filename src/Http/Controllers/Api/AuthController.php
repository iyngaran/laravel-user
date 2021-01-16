<?php

namespace Iyngaran\LaravelUser\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Mail\Message;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;
use Iyngaran\ApiResponse\Http\Traits\ApiResponse;
use Iyngaran\LaravelUser\Repositories\UserRepositoryInterface;
use Illuminate\Http\Resources\Json\JsonResource;
use Iyngaran\LaravelUser\Http\Resources\AuthenticatedUser as UserResource;
use Iyngaran\LaravelUser\Http\Requests\LoginRequest;
use Symfony\Component\HttpFoundation\Response;

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

    public function forgotPassword(Request $request)
    {
        $input = $request->all();
        $rules = array(
            'email' => "required|email",
        );
        $validator = Validator::make($input, $rules);
        if ($validator->fails()) {
            $arr = array("status" => 400, "message" => $validator->errors()->first(), "data" => array());
        } else {
            try {
                $response = Password::sendResetLink(
                    $request->only('email'),
                    function (Message $message) {
                        $message->subject($this->getEmailSubject());
                    }
                );
                dd($response);
                switch ($response) {
                    case Password::RESET_LINK_SENT:
                        return response()->json(["message" => trans($response)], Response::HTTP_OK);
                    case Password::INVALID_USER:
                        return response()->json(["message" => trans($response)], Response::HTTP_BAD_REQUEST);
                }
            } catch (\Swift_TransportException $ex) {
                $arr = array("status" => 400, "message" => $ex->getMessage(), "data" => []);
            } catch (Exception $ex) {
                $arr = array("status" => 400, "message" => $ex->getMessage(), "data" => []);
            }
        }
        return \Response::json($arr);
    }

}
