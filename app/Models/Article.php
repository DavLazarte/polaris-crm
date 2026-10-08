<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Article extends Model
{
    use HasTranslations;

    public $translatable = ['title', 'category', 'excerpt', 'body'];

    protected $fillable = [
        'title',
        'slug',
        'category',
        'img',
        'excerpt',
        'body',
        'is_featured',
        'is_published',
        'published_at',
    ];

    protected $casts = [
        'is_featured' => 'boolean',
        'is_published' => 'boolean',
        'published_at' => 'date',
    ];
}
