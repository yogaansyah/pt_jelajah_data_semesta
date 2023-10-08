<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
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
        // return parent::toArray($request);
        return [
            'comments_id' => $this->id,
            'comments_comment' => $this->comment,
            'comments_created_at' => $this->created_at,
            'comments_updated_at' => $this->updated_at,
            'comments_user_id' => new UserResource($this->whenLoaded('user')),
            'comments_news_id' => new NewsResource($this->whenLoaded('news')),
        ];
    }
}
