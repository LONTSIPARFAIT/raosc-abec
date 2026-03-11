<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class OrganizationCategory extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'description',
        'icon',
        'color',
    ];

    /**
     * Les organisations qui appartiennent à cette catégorie.
     */
    public function organizations(): BelongsToMany
    {
        return $this->belongsToMany(Organization::class);
    }
}
