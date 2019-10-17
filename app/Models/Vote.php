<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vote extends Model
{
    protected $guarded = [];

    public function voteable()
    {
    	return $this->morphTo();
    }

    public function user()
    {
    	return $this->belongsTo('App\Models\User');
    }
}
