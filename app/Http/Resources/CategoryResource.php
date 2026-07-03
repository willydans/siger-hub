<?php

// FILE: app/Http/Resources/CategoryResource.php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'           => $this->id,
            'name'         => $this->name,
            'slug'         => $this->slug,
            'icon'         => $this->icon,
            'color'        => $this->color,
            'description'  => $this->description,
            'order'        => $this->order,
            'is_active'    => $this->is_active,
            'article_count'=> $this->articles_count ?? 0,

            'parent' => $this->whenLoaded('parent', fn () => $this->parent ? [
                'id'   => $this->parent->id,
                'name' => $this->parent->name,
                'slug' => $this->parent->slug,
            ] : null),

            'children' => $this->whenLoaded('children', fn () =>
                CategoryResource::collection($this->children)
            ),
        ];
    }
}