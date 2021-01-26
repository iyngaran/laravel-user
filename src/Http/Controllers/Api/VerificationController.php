<?php

namespace Iyngaran\LaravelUser\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class VerificationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api')->except(['verify']);
    }


    public function verify($user_id, Request $request)
    {
        if (!$request->hasValidSignature()) {
            return response()->json(
                [
                    'error' => "Invalid email verification URL",
                ],
                253
            );
        }

        $user = $this->getUserModel()::findOrFail($user_id);
        $passwordResetToken = Str::random(32)
            . $user->id
            . Str::random(8)
            . Carbon::now()->timestamp
            . Str::random(8);
        if (!$user->hasVerifiedEmail()) {
            $user->markEmailAsVerified();
            $user->passwordResetTokens()->create(
                [
                    'token' => $passwordResetToken,
                    'expires_at' => Carbon::now()->addMinute(config('auth.passwords.users.expire')),
                ]
            );
        }
        
        return redirect('/login');

        return response()->json(
            [
                'msg' => 'Your account has been successfully verified.',
                'user' => $user,
                'token' => $passwordResetToken
            ],
            200
        );
    }

    public function resend()
    {
        if (auth()->user()->hasVerifiedEmail()) {
            return response()->json(
                [
                    'error' => "Email already verified",
                ],
                254
            );
        }
        auth()->user()->sendEmailVerificationNotification();
        return response()->json(
            [
                'msg' => "Email verification link sent on your email id",
            ],
            254
        );
    }

    private function getUserModel()
    {
        return config('iyngaran.user.user_model');
    }
}
