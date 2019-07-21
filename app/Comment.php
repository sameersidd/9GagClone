<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'post_id', 'user_id', 'content',
    ];
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function post()
    {
        return $this->belongsTo(Post::class, 'post_id', 'id');
    }

    public function userProfile()
    {
        return $this->hasOneThrough(Profile::class, User::class, 'user_id', 'user_id', 'id', 'id');
    }
}
