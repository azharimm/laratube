<?php

namespace App\Transformers;
use League\Fractal\TransformerAbstract;
use App\Models\Comment;

class CommentTransformer extends TransformerAbstract
{
	public function transfrom(Comment $comment)
	{
		return [
			'id'=>$comment->id,
			'user_id'=>$comment->user_id,
			'body'=>$comment->body,
			'created_at'=>$comment->created_at,
			'created_at_human'=>$comment->created_at->diffForHumans(),
		];
	}
}