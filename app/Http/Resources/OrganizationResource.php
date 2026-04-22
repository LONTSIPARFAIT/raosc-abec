<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrganizationResource extends JsonResource
{
    /**
     * Transforme la ressource en tableau pour l'API et le frontend.
     * Cette ressource permet de filtrer et formater les données de l'Organisation
     * renvoyées au composant Vue.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'slug' => $this->slug,
            'name' => $this->name,
            'logo' => $this->logo_url,
            'cover_image' => $this->cover_image_url,
            'gallery' => $this->gallery ? collect($this->gallery)->map(fn($img) => str_starts_with($img, 'http') ? $img : asset('storage/' . $img))->toArray() : [],
            'short_description' => $this->short_description,
            'description' => $this->description,
            'registration_number' => $this->registration_number,
            'founded_date' => $this->founded_date,
            'country' => $this->country,
            'city' => $this->city,
            'address' => $this->address,
            'email' => $this->email,
            'phone' => $this->phone,
            'website' => $this->website,
            'status' => $this->status,
            'is_featured' => $this->is_featured,
            
            // On charge conditionnellement les relations si elles ont été "eager loaded"
            'categories' => OrganizationCategoryResource::collection($this->whenLoaded('categories')),
            'members' => OrganizationMemberResource::collection($this->whenLoaded('members')),
            'projects' => ProjectResource::collection($this->whenLoaded('projects')),
        ];
    }
}
