<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrganizationMemberResource extends JsonResource
{
    /**
     * Transforme le membre de l'organisation en tableau.
     * Renvoie notamment l'utilisateur associé.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'role' => $this->role,
            'job_title' => $this->job_title,
            'user' => new UserResource($this->whenLoaded('user')),
        ];
    }
}
