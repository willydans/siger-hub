<?php

// FILE: app/Http/Resources/CommentResource.php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CommentResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'         => $this->id,
            'body'       => $this->body,
            'created_at' => $this->created_at->toDateTimeString(),
            'updated_at' => $this->updated_at->toDateTimeString(),

            'user' => $this->whenLoaded('user', fn () => [
                'id'         => $this->user->id,
                'name'       => $this->user->name,
                'avatar_url' => $this->user->avatar_url,
            ]),

            // Balasan komentar (nested, hanya 1 level)
            'replies' => $this->whenLoaded('replies', fn () =>
                CommentResource::collection($this->replies)
            ),

            'reply_count' => $this->replies_count ?? 0,

            // Flag apakah komentar ini milik user yang sedang login
            'is_own' => $this->when(
                auth()->check(),
                fn () => $this->user_id === auth()->id()
            ),
        ];
    }
}