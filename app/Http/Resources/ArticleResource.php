<?php

// FILE: app/Http/Resources/ArticleResource.php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ArticleResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'              => $this->id,
            'title'           => $this->title,
            'slug'            => $this->slug,
            'thumbnail_url'   => $this->thumbnail_url, // accessor dari model
            'content'         => $this->content,
            'status'          => $this->status,
            'visibility'      => $this->visibility,
            'version'         => $this->version,
            'views_count'     => $this->views_count,
            'downloads_count' => $this->downloads_count,
            'average_rating'  => $this->average_rating, // accessor dari model
            'meta_title'       => $this->meta_title,
            'meta_description' => $this->meta_description,
            'keywords'         => $this->keywords,
            'references'       => $this->references,
            'published_at'     => $this->published_at?->toDateTimeString(),
            'created_at'       => $this->created_at->toDateTimeString(),
            'updated_at'       => $this->updated_at->toDateTimeString(),

            // Relasi (hanya muncul kalau di-load, hindari N+1)
            'author' => $this->whenLoaded('author', fn () => [
                'id'   => $this->author->id,
                'name' => $this->author->name,
            ]),
            'category' => $this->whenLoaded('category', fn () => $this->category ? [
                'id'    => $this->category->id,
                'name'  => $this->category->name,
                'slug'  => $this->category->slug,
                'color' => $this->category->color,
                'icon'  => $this->category->icon,
            ] : null),
            'opd' => $this->whenLoaded('opd', fn () => $this->opd ? [
                'id'   => $this->opd->id,
                'name' => $this->opd->name,
                'slug' => $this->opd->slug,
            ] : null),
            'tags' => $this->whenLoaded('tags', fn () => $this->tags->map(fn ($tag) => [
                'id'   => $tag->id,
                'name' => $tag->name,
                'slug' => $tag->slug,
            ])),
            'attachments' => $this->whenLoaded('attachments', fn () => $this->attachments->map(fn ($att) => [
                'id'            => $att->id,
                'original_name' => $att->original_name,
                'file_type'     => $att->file_type,
                'file_size'     => $att->file_size_human,
                'download_url'  => $att->download_url,
            ])),
            'revisions' => $this->whenLoaded('revisions', fn () => $this->revisions->map(fn ($rev) => [
                'id'       => $rev->id,
                'section'  => $rev->section,
                'priority' => $rev->priority,
                'deadline' => $rev->deadline?->toDateString(),
                'notes'    => $rev->notes,
                'status'   => $rev->status,
            ])),

            // Flag tambahan — diisi controller kalau perlu (misal: is_bookmarked oleh user yg login)
            'is_bookmarked' => $this->when(isset($this->is_bookmarked), $this->is_bookmarked),
        ];
    }
}