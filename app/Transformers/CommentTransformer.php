<?php

namespace App\Transformers;

use App\Comment;
use App\User;
use Carbon\Carbon;
use League\Fractal\TransformerAbstract;

class CommentTransformer extends TransformerAbstract
{
    protected $availableIncludes = [
        'user', 'replies'
    ];

    public function transform(Comment $comment)
    {
        Carbon::setLocale('ru');

        return [
            'id' => $comment->id,
            'user_id' => $comment->user_id,
            'body' => $comment->body,
            'created_at' => $comment->created_at->toDateTimeString(),
            'created_at_human' => $comment->created_at->diffForHumans(),
        ];
    }

    public function includeUser(Comment $comment)
    {
        return $this->item($comment->user, new UserTransformer);
    }

    public function includeReplies(Comment $comment)
    {
        return $this->collection($comment->replies, new CommentTransformer);
    }
}