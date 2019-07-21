<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Post extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'img',
    ];

    public static function boot()
    {
        parent::boot();
        static::created(function ($post) {
            DB::table('votes_count')->insert([
                'post_id' => $post->id
            ]);
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'post_id', 'id');
    }

    public function upvote($post_id)
    {
        return DB::table('votes_count')->where('post_id', '=', $post_id)->increment('upvotes');
    }

    public function downvote($post_id)
    {
        return DB::table('votes_count')->where('post_id', '=', $post_id)->increment('downvotes');
    }
}
