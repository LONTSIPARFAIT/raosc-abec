<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = [
        'organization_id',
        'title',
        'type',
        'description',
        'cover_image',
        'status',
    ];

    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }
}
