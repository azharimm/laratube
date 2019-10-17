<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Channel extends Model
{
    use Searchable;
    
    protected $guarded = [];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getRouteKeyName()
    {
    	return 'slug';
    }

    public function videos()
    {
    	return $this->hasMany('App\Models\Video');
    }

    public function getImage()
    {
        if(!$this->image_filename){
            return config('laratube.buckets.images').'/profile/default.jpg';
        }

        return config('laratube.buckets.images').'/profile/'.$this->image_filename;
    }

    public function subscriptions()
    {
        return $this->hasMany('App\Models\Subscription');
    }

    public function subscriptionCount()
    {
        return $this->subscriptions->count();
    }

    public function totalVideoViews()
    {
        return $this->hasManyThrough('App\Models\VideoView', 'App\Models\Video')->count();
    }
}
