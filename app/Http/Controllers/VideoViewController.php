<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Video;
use Carbon\Carbon;

class VideoViewController extends Controller
{
	const BUFFER = 30;
    public function create(Request $request, Video $video)
    {
    	if(!$video->canBeAccessed($request->user())){
    		return;
    	}

    	//grab last view for user
    	if($request->user()){
    		$lastUserView = $video->views()->latestByUser($request->user())->first();

	    	//check if in buffer
    		if($this->withinBuffer($lastUserView)){
		    	//return if too soon
    			return;
    		}
    	}
    	//get last view for current ip address
    	$lastViewIp = $video->views()->latestByIp($request->ip())->first();
    	//do the same
    	if($this->withinBuffer($lastViewIp)){
    		return;
    	}

    	$video->views()->create([
    		'user_id'=>$request->user() ? $request->user()->id : null,
    		'ip'=>$request->ip()
    	]);

    	return response()->json(null, 200);
    }

    protected function withinBuffer($view)
    {
    	return $view && $view->created_at->diffInSeconds(Carbon::now()) < self::BUFFER;
    }
}
