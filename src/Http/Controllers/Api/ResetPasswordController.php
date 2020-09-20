<?php

namespace Iyngaran\LaravelUser\Http\Controllers\Api;


use Iyngaran\LaravelUser\Actions\ResetPasswordAction;
use Iyngaran\LaravelUser\Models\PasswordResetToken;
use App\Http\Resources\User\User as UserResource;
use Iyngaran\ApiResponse\Http\Traits\ApiResponse;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class ResetPasswordController extends Controller
{
    use ApiResponse;

    public function __invoke(Request $request)
    {
        $token = $request->input('token');
        $password = $request->input('password');
        $confirm_password = $request->input('confirm_password');
        if ($password != $confirm_password) {
            return $this->responseWithValidationError(
                "Reset Password",
                "Password doest not match with confirm password"
            );
        }

        $passwordResetToken = PasswordResetToken::where('token', '=', $token)
            ->where('used_at', null)
            ->where('expires_at', '>=', Carbon::now()->toDateTimeString())->first();

        if ($passwordResetToken) {
            $tokenable_id = $passwordResetToken->tokenable_id;
            $tokenable_type = $passwordResetToken->tokenable_type;

            if ($tokenable_type == "App\User") {
                $passwordResetToken->update(
                    [
                        'used_at' => Carbon::now()
                    ]
                );

                return $this->updatedResponse(
                    new UserResource((new ResetPasswordAction())->execute(['password' => $password], $tokenable_id))
                );
            }
        }

        return $this->responseWithValidationError("Reset Password", "Your token has expired");
    }
}
