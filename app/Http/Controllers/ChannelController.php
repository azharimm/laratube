<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ChannelUpdateRequest;
use App\Models\Channel;
use App\Jobs\UploadImage;
use File;
class ChannelController extends Controller
{
    public function edit(Channel $channel)
    {
    	$this->authorize('edit', $channel);

    	return view('channel.settings.edit', [
    		'channel'=>$channel
    	]);
    }

    public function update(ChannelUpdateRequest $request, Channel $channel)
    {
    	$this->authorize('update', $channel);

    	$channel->update([
    		'name'=>$request->name,
    		'slug'=>$request->slug,
    		'description'=>$request->description
    	]);

        if($request->file('image')){
            $request->file('image')->move(storage_path().'/uploads',$fileId = uniqid(true));
            
            if($this->dispatch(new UploadImage($channel, $fileId))){
                $channel->image_filename = $fileId.'.png';
                $channel->save();
            }
        }


    	return redirect()->to("/channel/{$channel->slug}/edit");

    }

    public function show(Channel $channel)
    {
        return view('channel.show', [
            'channel'=>$channel,
            'videos'=>$channel->videos()->visible()->latestFirst()->paginate(5)
        ]);
    }
}
