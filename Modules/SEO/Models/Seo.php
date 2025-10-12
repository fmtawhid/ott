<?php

namespace Modules\SEO\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\SEO\Database\Factories\SeoFactory;

class Seo extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     */
    protected $table = 'seo';

    /**
     * The attributes that are mass assignable.
     */
    // app/Models/Seo.php or Modules/SEO/Models/Seo.php
    protected $fillable = [
        'meta_title',
        'short_description',
        'meta_keywords',
        'google_site_verification',
        'canonical_url',
        'seo_image',
    ];


    /**
     * The factory for the model.
     */
    protected static function newFactory(): SeoFactory
    {
        return SeoFactory::new();  // Uncommented to enable the factory
    }
}
