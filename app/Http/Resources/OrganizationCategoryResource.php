<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrganizationCategoryResource extends JsonResource
{
    /**
     * Transforme la catégorie en tableau.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'description' => $this->description,
            'icon' => $this->icon,
            'color' => $this->color,
        ];
    }
}

//  À l'accueil, on mentionne que le réseau est l'initiative de l'association ABEC mais on ne dit pas ce qu'est L'ABEC. Je propose qu'à l'accueil et pas seulement dans la rubrique "à propos", qu'on fasse la publicité de l'ABEC aussi.  e aussi pour les image sur le site il faut mettre les image africaine plus les images des blanc mais celle africaine pour que le site soit plus coherent tous les img doivent etre reflecter l'afrique et aussi sur  le formualire d'ajout d'une orgaisation voici les info a ajouter televerser un document de presentation de l'ong et ce document doit etre visibel sur les detail d'une entreprise pour que les visiteur puisse voir et telecharger la fiche et aussi sur lors de la creation tourjours d'une orgaisation ou il y'a categorie on donne la possibiliter au user de saisir en cliquant sur autre et sa ajoute dans la bd directement et aussi televerser un document atestant que l'entreprise existe meme si il ne sont pas encore legaliser par exemple status reglement ou autre document officiel de l'organisation mais ces doc sont visible uniquelent par les admin et le createur de l'associaltion autre info publique sur le formulaire ajouter le nombre de membre de l'organisation et le responsable et optionnemelent son vice et pour chacun avec (leur numero de telephone email ,photos , numero d'identifiant; passport ou autre  nom complet nb: priver ) mais leur nom son visible sur le show de l'organisation 