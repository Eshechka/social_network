<?php

namespace App\Http\Resources\Post;

use App\Http\Resources\User\UserResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
          'id' => $this->id,
          'title' => $this->title,
          'content' => $this->content,
          'image_url' => $this->image?->url,
          'date' => $this->date,
          'user' => new UserResource($this->user),
          'is_liked' => $this->is_liked,
          'likes_count' => count($this->likes),
        ];
    }
}
