<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;

class PostsController extends Controller
{
    function view(Post $post)
    {
        $post->load('comment');
        return view('posts/view')->with('post', $post);
    }

    function create()
    {
        $this->middleware('auth');
        return view('posts/create');
    }

    function store(Request $request)
    {
        $this->middleware('auth');
        $data = $request->validate([
            'title' => 'required',
            'img' => ['required', 'image'],
        ]);

        $path = request('img')->store('uploads', 'public');

        auth()->user()->posts()->create([
            'title' => $data['title'],
            'img' => $path
        ]);
        return redirect()->back();
    }

    //Upvote a Post
    function upvote(Post $post)
    {
        $post->upvote($post->id);
    }

    //Downvote a Post
    function downvote(Post $post)
    {
        $post->downvote($post->id);
    }

    function delete(Post $post)
    {
        $this->middleware('auth');
        $this->authorize('update', $post);
        if ($post->delete())
            return response('Deleted', 200);
        else
            return response('Failed', 400);
    }
}
