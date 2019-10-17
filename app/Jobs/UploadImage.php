<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Storage;
use File;
use Image;
use App\Models\Channel;

class UploadImage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public $channel;
    public $fileId;

    public function __construct(Channel $channel, $fileId)
    {
        $this->channel = $channel;
        $this->fileId = $fileId;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $path = storage_path().'/uploads/'.$this->fileId;
        $fileName = $this->fileId.'.png';

        // resize image
        Image::make($path)->encode('png')->fit(40,40, function($c){
            $c->upsize();
        })->save();

        //upload to s3
        if(Storage::disk('s3images')->put('profile/'.$fileName, fopen($path, 'r+'))){
            File::delete($path);
        }
        //save filename
        $this->channel->image_filename = $fileName;
        $this->channel->save();
    }
}
