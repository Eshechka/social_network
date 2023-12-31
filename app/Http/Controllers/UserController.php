<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\StatRequest;
use App\Http\Resources\Post\PostResource;
use App\Http\Resources\User\UserResource;
use App\Models\Post;
use App\Models\SubscriberFollowing;
use App\Models\User;
use Illuminate\Support\Facades\DB;


class UserController extends Controller
{
    public function index()
    {
        $users = User::whereNot('id', auth()->id())->get();

        $followingIds = SubscriberFollowing::query()
            ->where('subscriber_id', auth()->id())
            ->get('following_id')->pluck('following_id')->toArray();

        foreach ($users as $user) {
            $user['is_followed'] = in_array($user->id, $followingIds);
        }

        return UserResource::collection($users);
    }

    public function stats(StatRequest $request)
    {
        $data = $request->validated();
        $user = $data['user_id'] ? User::find($data['user_id']) : auth()->user();

        $posts = $user->posts;

        $stats['likes_count'] = 0;
        foreach ($posts as $post) {
            $stats['likes_count'] = $stats['likes_count'] + $post->likes()->count();
        }

        $stats['posts_count'] = $user->posts()->count();
        $stats['followings_count'] = $user->followings()->count();
        $stats['subscribers_count'] = $user->subscribers()->count();

        return response()->json(['data' => $stats]);
    }

    public function posts(User $user)
    {
        $posts = $user->posts()->get();

        foreach ($posts as $post) {
            $post['is_liked'] = in_array(auth()->id(), $post->likes->pluck('id')->toArray());
        }

        return PostResource::collection($posts);
    }

    public function toggleFollowing(User $user)
    {
        $res = auth()->user()->followings()->toggle($user->id);

        return ['is_followed' => count($res['attached']) > 0];
    }

    public function followingPosts()
    {
        $followingIds = auth()->user()->followings()->latest()->get()->pluck('id')->toArray();

        $likedByAuthUserIds = auth()->user()->likedPosts()->get()->pluck('id')->toArray();

        $posts = Post::query()
            ->whereIn('user_id', $followingIds)
            ->whereNotIn('id', $likedByAuthUserIds)
            ->get();

        return PostResource::collection($posts);
    }
}
