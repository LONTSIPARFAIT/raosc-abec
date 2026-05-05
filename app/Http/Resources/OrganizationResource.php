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
            'rejection_reason' => $this->rejection_reason,
            'is_featured' => $this->is_featured,
            
            // Nouvelles informations
            'member_count' => $this->member_count,
            'presentation_doc' => $this->presentation_doc_url,
            'responsible_name' => $this->responsible_name,
            'responsible_photo' => $this->responsible_photo_url,
            'vice_responsible_name' => $this->vice_responsible_name,
            'vice_responsible_photo' => $this->vice_responsible_photo_url,

            // Informations privées (Admin global ou Membre autorisé uniquement)
            $this->mergeWhen(auth()->check() && (
                auth()->user()->role === 'admin' || 
                auth()->id() === $this->user_id || 
                $this->members()->where('user_id', auth()->id())->exists()
            ), [
                'legal_docs' => $this->legal_docs ? collect($this->legal_docs)->map(fn($doc) => str_starts_with($doc, 'http') ? $doc : asset('storage/' . $doc))->toArray() : [],
                'responsible_email' => $this->responsible_email,
                'responsible_phone' => $this->responsible_phone,
                'responsible_id_doc' => $this->responsible_id_doc ? (str_starts_with($this->responsible_id_doc, 'http') ? $this->responsible_id_doc : asset('storage/' . $this->responsible_id_doc)) : null,
                'vice_responsible_email' => $this->vice_responsible_email,
                'vice_responsible_phone' => $this->vice_responsible_phone,
                'vice_responsible_id_doc' => $this->vice_responsible_id_doc ? (str_starts_with($this->vice_responsible_id_doc, 'http') ? $this->vice_responsible_id_doc : asset('storage/' . $this->vice_responsible_id_doc)) : null,
            ]),
            
            // On charge conditionnellement les relations si elles ont été "eager loaded"
            'categories' => OrganizationCategoryResource::collection($this->whenLoaded('categories')),
            'members' => OrganizationMemberResource::collection($this->whenLoaded('members')),
            'projects' => ProjectResource::collection($this->whenLoaded('projects')),
        ];
    }
}
