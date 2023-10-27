<?php

namespace App\Http\Controllers;

use App\Http\Requests\Post\StoreRequest;
use App\Http\Resources\Post\PostResource;
use App\Models\Post;
use App\Models\PostImage;
use Illuminate\Support\Facades\DB;


class PostController extends Controller
{
    protected function index()
    {
        $posts = Post::latest()->get();

        return PostResource::collection($posts);
    }


    protected function store(StoreRequest $request)
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
            return response()->json([
                'error' => $exception->getMessage(),
            ]);
        }

        return new PostResource($post);
    }
}
