<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Video;

class EncodingWebhookController extends Controller
{
    public function handle(Request $request)
    {
    	$event = camel_case($request->event);

    	if(method_exists($this, $event)){
    		$this->{$event}($request);
    	}
    	
    }

    protected function videoEncoded(Request $request)
    {
    	$video = $this->getVideoFilename($request->original_filename);

    	//update processed column
    	$video->processed = true;
    	$video->video_id = $request->encoding_ids[0];
    	$video->save();
    }

    protected function encodingProgress(Request $request)
    {
    	$video = $this->getVideoFilename($request->original_filename);
    	
    	$video->processed_percentage = $request->progress;
    	$video->save();
    }

    protected function getVideoFilename($filename)
    {
    	return Video::where('video_filename', $filename)->firstOrFail();
    }
}
