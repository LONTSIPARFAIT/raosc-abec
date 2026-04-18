<?php

namespace App\Http\Resources;

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
            'slug' => $this->slug,
            'title' => $this->title,
            'summary' => $this->summary,
            'content' => $this->content,
            'category' => $this->category,
            'read_time' => $this->read_time,
            'cover_image' => $this->cover_image ? (str_starts_with($this->cover_image, 'http') ? $this->cover_image : asset('storage/' . $this->cover_image)) : null,
            'created_at' => $this->created_at ? $this->created_at->translatedFormat('j F Y') : null,
            'organization' => new OrganizationResource($this->whenLoaded('organization')),
        ];
    }
}
