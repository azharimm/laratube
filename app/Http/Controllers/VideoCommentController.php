<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Video;
use App\Models\Comment;
use App\Http\Resources\CommentResource;
use App\Http\Requests\CreateVideoCommentRequest;

class VideoCommentController extends Controller
{
    public function index(Video $video)
    {
    	return CommentResource::collection($video->comments()->latestFirst()->get());
    }

    public function create(Request $request, Video $video)
    {
    	//authorize
    	$this->authorize('comment',$video);
    	$comment = $video->comments()->create([
    		'body'=> $request->body,
    		'reply_id'=>$request->get('reply_id',null),
    		'user_id'=>$request->user()->id
    	]);

   		return new CommentResource($comment);
    }

    public function delete(Video $video, Comment $comment)
    {
    	$this->authorize('delete', $comment);

    	$comment->delete();

    	return response()->json(null, 200);
    }
}
