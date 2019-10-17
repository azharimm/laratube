<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VideoView extends Model
{
    protected $guarded = [];

    public function scopelatestByUser($query, User $user)
    {
    	return $query->byUser($user)->orderBy('created_at','desc')->take(1);
    }

    public function scopelatestByIp($query, $ip)
    {
    	return $query->where('ip',$ip)->orderBy('created_at','desc')->take(1);
    }

    public function scopeByUser($query, User $user)
    {
    	return $query->where('user_id',$user->id);
    }

}
