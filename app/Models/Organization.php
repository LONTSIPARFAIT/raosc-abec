<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Organization extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'slug',
        'logo',
        'cover_image',
        'short_description',
        'description',
        'registration_number',
        'founded_date',
        'country',
        'city',
        'address',
        'latitude',
        'longitude',
        'email',
        'phone',
        'website',
        'social_links',
        'status',
        'approved_at',
        'is_featured',
        'gallery',
    ];

    protected $casts = [
        'founded_date' => 'date',
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
        'social_links' => 'array',
        'approved_at' => 'datetime',
        'is_featured' => 'boolean',
        'gallery' => 'array',
    ];

    /**
     * Le créateur de l'organisation
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Les catégories de cette organisation.
     */
    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(OrganizationCategory::class);
    }

    /**
     * Les membres de l'organisation.
     */
    public function members(): HasMany
    {
        return $this->hasMany(OrganizationMember::class);
    }

    /**
     * Les projets de l'organisation.
     */
    public function projects(): HasMany
    {
        return $this->hasMany(Project::class);
    }

    /**
     * Les actualités publiées par l'organisation.
     */
    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }

    /**
     * Accesseur pour le logo.
     */
    protected function logoUrl(): \Illuminate\Database\Eloquent\Casts\Attribute
    {
        return \Illuminate\Database\Eloquent\Casts\Attribute::make(
            get: fn () => $this->logo 
                ? (str_starts_with($this->logo, 'http') ? $this->logo : asset('storage/' . $this->logo)) 
                : null,
        );
    }

    /**
     * Accesseur pour l'image de couverture.
     */
    protected function coverImageUrl(): \Illuminate\Database\Eloquent\Casts\Attribute
    {
        return \Illuminate\Database\Eloquent\Casts\Attribute::make(
            get: function () {
                if ($this->cover_image) {
                    return str_starts_with($this->cover_image, 'http') ? $this->cover_image : asset('storage/' . $this->cover_image);
                }
                
                if (!empty($this->gallery) && is_array($this->gallery) && count($this->gallery) > 0) {
                    $first = $this->gallery[0];
                    return str_starts_with($first, 'http') ? $first : asset('storage/' . $first);
                }

                return null;
            }
        );
    }
}
