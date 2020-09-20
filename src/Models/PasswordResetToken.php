<?php


namespace Iyngaran\LaravelUser\Models;


use Illuminate\Database\Eloquent\Model;
use App\User;

class PasswordResetToken extends Model
{
    protected $table = 'password_reset_tokens';
    protected $guarded = [];

    public function tokenable()
    {
        $this->morphTo();
    }
}
