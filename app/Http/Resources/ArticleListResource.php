<?php

// FILE: app/Http/Resources/ArticleListResource.php
// Versi RINGKAS untuk endpoint list — tanpa "content" penuh supaya response cepat & ringan

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

class ArticleListResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'             => $this->id,
            'title'          => $this->title,
            'slug'           => $this->slug,
            'thumbnail_url'  => $this->thumbnail_url,
            'excerpt'        => Str::limit(strip_tags($this->content), 150),
            'status'         => $this->status,
            'visibility'     => $this->visibility,
            'views_count'    => $this->views_count,
            'average_rating' => $this->average_rating,
            'published_at'   => $this->published_at?->toDateTimeString(),

            'author' => $this->whenLoaded('author', fn () => [
                'id'   => $this->author->id,
                'name' => $this->author->name,
            ]),
            'category' => $this->whenLoaded('category', fn () => $this->category ? [
                'id'    => $this->category->id,
                'name'  => $this->category->name,
                'color' => $this->category->color,
            ] : null),
            'tags' => $this->whenLoaded('tags', fn () => $this->tags->pluck('name')),
        ];
    }
}