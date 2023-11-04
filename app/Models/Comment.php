<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;
    protected $guarded = false;
    protected $with = ['parentComment'];

    public function user() {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function getDateAttribute() {
        return $this->created_at->diffForHumans();
    }

    public function parentComment() {
        return $this->hasOne(Comment::class, 'id', 'parent_id');
    }

    public function childComments() {
        return $this->hasMany(Comment::class, 'parent_id', 'id');
    }
}
