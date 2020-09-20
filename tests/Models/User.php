<?php


namespace Iyngaran\LaravelUser\Tests\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use \Iyngaran\LaravelUser\Models\UserProfile;

class User extends Authenticatable
{
    use Notifiable, HasApiTokens;
    use HasRoles;
    protected $guard_name = 'api';
    protected $with = ['profile'];
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','password_change_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }

    public function passwordResetTokens()
    {
        return $this->morphMany(PasswordResetToken::class, 'tokenable');
    }

    public function profile()
    {
        return $this->hasOne(UserProfile::class);
    }
}
