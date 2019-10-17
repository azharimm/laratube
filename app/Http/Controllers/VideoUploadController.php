<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Jobs\UploadVideo;
use File;

class VideoUploadController extends Controller
{
    public function index()
    {
    	return view('video.upload');
    }

    public function store(Request $request)
    {
        ini_set('upload_max_filesize', '100M');
    	//grab user's channel
    	$channel = $request->user()->channels()->first();
    	//lookup the video
        $video = $channel->videos()->where('uid',$request->uid)->firstOrFail();
        //move to temp location
        $request->file('video')->move(storage_path().'/uploads', $video->video_filename);
        
        //upload to s3
        $this->dispatch(new UploadVideo($video->video_filename));

        return response()->json(null, 200);
    }
}
