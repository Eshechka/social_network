<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;
    protected $guarded = false;

    protected $with = ['image', 'user'];

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
}
