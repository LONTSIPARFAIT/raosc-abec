<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Post extends Model
{
    protected $fillable = [
        'organization_id',
        'title',
        'slug',
        'summary',
        'content',
        'cover_image',
        'category',
        'read_time'
    ];

    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }
    
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($post) {
            if (!$post->slug) {
                $post->slug = Str::slug($post->title) . '-' . uniqid();
            }
        });
    }
}
