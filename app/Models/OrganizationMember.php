<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrganizationMember extends Model
{
    protected $fillable = [
        'organization_id',
        'user_id',
        'role',
        'job_title',
    ];

    /**
     * L'organisation à laquelle appartient ce membre.
     */
    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class);
    }

    /**
     * L'utilisateur qui est membre.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
