<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\Orderable;

class Comment extends Model
{
	use SoftDeletes, Orderable;

    protected $guarded = [];

    public function commentable()
    {
    	return $this->morphTo();
    }

    public function replies()
    {
    	return $this->hasMany('App\Models\Comment','reply_id','id')->orderBy('created_at','desc');
    }

    public function user()
    {
    	return $this->belongsTo('App\Models\User');
    }
}
