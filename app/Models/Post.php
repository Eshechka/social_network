<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;
    protected $guarded = false;

    protected $with = ['image', 'user', 'likes', 'repostedFromPost', 'comments'];
    protected $withCount = ['comments'];

    public function user() {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function image() {
        return $this->hasOne(PostImage::class, 'post_id', 'id')
            ->whereNotNull('post_id');
    }

    public function getDateAttribute() {
        return $this->created_at->diffForHumans();
    }

    public function likes() {
        return $this->belongsToMany(User::class, 'liked_posts', 'post_id', 'user_id');
    }

    public function repostedPosts()
    {
        return $this->hasMany(Post::class, 'reposted_id', 'id');
    }

    public function repostedFromPost() {
        return $this->belongsTo(Post::class, 'reposted_id', 'id');
    }

    public function comments() {
        return $this->hasMany(Comment::class, 'post_id', 'id');
    }
}
