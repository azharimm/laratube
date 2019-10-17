<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Comment;
use Carbon\Carbon;

class CommentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $ret = [];
        foreach($this->replies as $reply)
        {
            $arr = [
                'id'=>$reply->id,
                'user_id'=>$reply->user_id,
                'user_id'=>$reply->user_id,
                'commentable_id'=>$reply->commentable_id,
                'commentable_type'=>$reply->commentable_type,
                'body'=>$reply->body,
                'created_at'=>$reply->created_at,
                'created_at_human'=>$reply->created_at->diffForHumans(),
                'channel'=>[
                    'name'=>$reply->user->channels->first()->name,
                    'slug'=>$reply->user->channels->first()->slug,
                    'image'=>$reply->user->channels->first()->getImage(),
                ]
            ];

            array_push($ret, $arr);
        }
        return [
            'id'=>$this->id,
            'user_id'=>$this->user_id,
            'body'=>$this->body,
            'created_at'=>$this->created_at,
            'created_at_human'=>$this->created_at->diffForHumans(),
            'channel'=>[
                'name'=>$this->user->channels->first()->name,
                'slug'=>$this->user->channels->first()->slug,
                'image'=>$this->user->channels->first()->getImage(),
            ],
            'replies'=>$ret,
        ];
    }
}
