<?php

// FILE: app/Http/Resources/UserResource.php
// Resource ini mengontrol shape data user yang keluar ke response JSON
// Sehingga password, remember_token, dll tidak pernah bocor

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'             => $this->id,
            'name'           => $this->name,
            'email'          => $this->email,
            'phone'          => $this->phone,
            'avatar_url'     => $this->avatar_url, // accessor dari model
            'is_active'      => $this->is_active,
            'last_login_at'  => $this->last_login_at?->toDateTimeString(),
            'created_at'     => $this->created_at->toDateString(),

            // Role & permissions dari Spatie
            'roles'          => $this->getRoleNames(),          // ['admin'] / ['staff'] / ['user']
            'permissions'    => $this->getAllPermissions()->pluck('name'),

            // Relasi OPD
            'opd' => $this->whenLoaded('opd', fn () => [
                'id'   => $this->opd->id,
                'name' => $this->opd->name,
                'slug' => $this->opd->slug,
            ]),
        ];
    }
}