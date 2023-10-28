<?php

namespace App\Http\Controllers;

use App\Http\Resources\Post\PostResource;
use App\Http\Resources\User\UserResource;
use App\Models\User;
use Illuminate\Support\Facades\DB;


class UserController extends Controller
{
    public function index()
    {
        $users = User::whereNot('id', auth()->id())->get();

        return UserResource::collection($users);
    }

    public function posts(User $user)
    {
        $posts = $user->posts()->get();

        return PostResource::collection($posts);
    }
}
