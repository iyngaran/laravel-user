<?php


namespace Iyngaran\LaravelUser\Models;

use Illuminate\Database\Eloquent\Model;

class UserProfile extends Model
{
    protected $fillable = [
        'company_name', 'address','mobile','phone','logo','fb','in','location_lat','location_lon','user_id'
    ];

    public function user()
    {
        return $this->belongsTo($this->getUserModel(),"user_id");
    }

    private function getUserModel()
    {
        return config('iyngaran.user.user_model');
    }
}
