<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function home()
    {
        $user = auth()->user();
        $posts = Post::whereIn('user_id', $user->id)->with('user')->latest()->paginate(5);
        return view('home', compact('posts', 'user'));
    }
}
