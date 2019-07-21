<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Comment;

class CommentsController extends Controller
{
    function create()
    {
        $this->middleware('auth');
        $data = request()->validate([
            'postID' => ['required', 'exists:posts,id'],
            'content' => ['required', 'string']
        ]);

        $post = request('postID');
        $status = Post::find($post)->comments()->create([
            'user_id' => auth()->user()->id,
            'content' => $data['content']
        ]);
        if ($status)
            return response('Created', 200);
        else
            return response('Failed', 400);
    }

    function delete($comment)
    {
        $this->middleware('auth');
        $comment = Comment::find($comment)->delete();
        if ($comment)
            return response('Deleted', 200);
        else
            return response('Failed', 400);
    }
}
