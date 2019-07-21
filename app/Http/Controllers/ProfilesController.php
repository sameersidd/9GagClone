<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class ProfilesController extends Controller
{
    public function view($user)
    {
        $user = User::findorFail($user);
        $posts = Cache::remember(
            'posts.' . $user->id,
            now()->addMinutes(5),
            function () use ($user) {
                return $user->posts;
            }
        );
        $postCount = Cache::remember(
            'posts.count.' . $user->id,
            now()->addMinutes(5),
            function () use ($user) {
                return $user->posts->count();
            }
        );
        return view('profiles/index', compact('user', 'posts'));
    }

    public function edit($user)
    {
        $user = User::findorFail($user);
        $this->authorize('update', $user->profile);
        return view('profiles/edit')->with('user', $user);
    }

    public function update($user)
    {
        $data = request()->validate([
            'Name' => ['required', 'max:15'],
            'description' => '',
            'url' => 'url',
            'img' => 'image'
        ]);
        $user = User::findorFail($user);

        $this->authorize('update', $user->profile);

        if (request('img')) {
            $path = request('img')->store('profiles', 'public');
            $data = array_merge(
                $data,
                ['img' => $path]
            );
        }
        auth()->user()->profile->update($data);

        return redirect()->back();
    }
}
