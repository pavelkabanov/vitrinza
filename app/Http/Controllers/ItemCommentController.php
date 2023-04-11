<?php

namespace App\Http\Controllers;

use App\Item;
use App\Comment;
use Illuminate\Http\Request;
use App\Transformers\CommentTransformer;
use App\Http\Requests\CreateItemCommentRequest;

class ItemCommentController extends Controller
{
    public function index(Item $item)
    {
        return response()->json(
            fractal()->collection($item->comments()->latestFirst()->get())
                ->parseIncludes(['user', 'replies', 'replies.user'])
                ->transformWith(new CommentTransformer)
                ->toArray()
        );
    }

    public function create(CreateItemCommentRequest $request, Item $item)
    {
        $comment = $item->comments()->create([
            'body' => $request->body,
            'reply_id' => $request->get('reply_id', null),
            'user_id' => $request->user()->id,
        ]);

        return response()->json(
            fractal()->item($comment)
                ->parseIncludes(['user', 'replies'])
                ->transformWith(new CommentTransformer)
                ->toArray()
        );
    }

    public function delete(Item $item, Comment $comment)
    {
        $this->authorize('delete', $comment);

        $comment->delete();

        return response()->json(null, 200);
    }
}
