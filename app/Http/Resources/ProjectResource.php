<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProjectResource extends JsonResource
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
            'description' => $this->description,
            'type' => $this->type,
            'status' => $this->status,
            'cover_image' => $this->cover_image ? (str_starts_with($this->cover_image, 'http') ? $this->cover_image : asset('storage/' . $this->cover_image)) : null,
            'gallery' => $this->gallery ? collect($this->gallery)->map(fn($img) => str_starts_with($img, 'http') ? $img : asset('storage/' . $img))->toArray() : [],
            'created_at' => $this->created_at,
        ];
    }
}
