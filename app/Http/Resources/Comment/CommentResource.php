<?php

namespace App\Http\Resources\Comment;

use App\Http\Resources\User\UserResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CommentResource extends JsonResource
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
          'body' => $this->body,
          'date' => $this->date,
          'parent_id' => $this->parent_id,
          'child_comments' => CommentResource::collection($this->childComments),
          'parent_comment' => new ParentCommentResource($this->parentComment),
          'user' => new UserResource($this->user),
        ];
    }
}
