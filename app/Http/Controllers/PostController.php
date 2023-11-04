<?php

namespace App\Http\Controllers;

use App\Http\Requests\Comment\StoreCommentRequest;
use App\Http\Requests\Post\RepostRequest;
use App\Http\Requests\Post\StorePostRequest;
use App\Http\Resources\Comment\CommentResource;
use App\Http\Resources\Post\PostResource;
use App\Models\Comment;
use App\Models\LikedPost;
use App\Models\Post;
use App\Models\PostImage;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;


class PostController extends Controller
{
    public function index()
    {
        $posts = Post::latest()->get();

        $likedIds = LikedPost::query()->where('user_id', auth()->id())
            ->get('post_id')->pluck('post_id')->toArray();

        foreach ($posts as $post) {
            $post['is_liked'] = in_array($post->id, $likedIds);
        }

        return PostResource::collection($posts);
    }

    public function store(StorePostRequest $request)
    {
        $data = $request->validated();

        try {
            DB::beginTransaction();

                $dataImageId = $data['image_id'];
                unset($data['image_id']);
                $data['user_id'] = auth()->id();

                $post = Post::create($data);

                if(isset($dataImageId)) {
                    $postImage = PostImage::find($dataImageId);

                    $postImage->update([
                        'status' => true,
                        'post_id' => $post->id,
                    ]);
                }

                PostImage::clearStorage();

            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            return response()->json(['error' => $exception->getMessage()], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
        }

        return new PostResource($post);
    }

    public function toggleLike(Post $post)
    {
        $res = $post->likes()->toggle(auth()->id());

        return ['is_liked' => count($res['attached']) > 0];
    }

    public function repost(RepostRequest $request, Post $post)
    {
        $data = $request->validated();

        try {
            DB::beginTransaction();

            $data['user_id'] = auth()->id();
            $data['reposted_id'] = $post->id;
            $data['image_id'] = $post->image_id;

            $post = Post::create($data);

            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            return response()->json([
                'error' => $exception->getMessage(),
            ]);
        }

        return new PostResource($post);
    }

    public function comment(StoreCommentRequest $request, Post $post)
    {
        $data = $request->validated();

        try {
            DB::beginTransaction();

            $data['user_id'] = auth()->id();
            $data['post_id'] = $post->id;

            $comment = Comment::create($data);

            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            return response()->json([
                'error' => $exception->getMessage(),
            ]);
        }

        return new CommentResource($comment);
    }

    public function comments(Post $post)
    {
        $comments = $post->comments;

        return CommentResource::collection($comments);
    }
}
