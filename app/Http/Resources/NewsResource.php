<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use App\Http\Resources\NewsResource;
use App\Http\Resources\UserResource;
use App\Http\Resources\CommentResource;
use Illuminate\Http\Resources\Json\JsonResource;

class NewsResource extends JsonResource
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
            'id' => $this->id,
            'news_title' => $this->title,
            'news_content' => $this->content,
            'news_created_at' => $this->created_at,
            'news_updated_at' => $this->updated_at,
            'news_author' => new UserResource($this->whenLoaded('user')),
            'user_comments' => CommentResource::collection($this->whenLoaded('comments')),

        ];
    }
}
