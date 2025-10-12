<?php

namespace Modules\Page\Models;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Page extends BaseModel
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'pages';
    protected $fillable = ['name', 'description', 'status', 'slug'];

    const CUSTOM_FIELD_MODEL = 'Modules\Page\Models\Page';

    /**
     * Create a new factory instance for the model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */


    protected $appends = ['feature_image'];

    protected function getFeatureImageAttribute()
    {
        $media = $this->getFirstMediaUrl('feature_image');
        return isset($media) && ! empty($media) ? $media : 'https://dummyimage.com/600x300/cfcfcf/000000.png';
    }
    protected static function newFactory()
    {
        // return \Modules\Page\database\factories\PageFactory::new();
    }

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($page) {
            if (empty($page->slug)) {
                $slug = Str::slug($page->name);
                $originalSlug = $slug;
                $count = 1;


                while (self::where('slug', $slug)->exists()) {
                    $slug = $originalSlug . '-' . $count++;
                }

                $page->slug = $slug;
            }
        });
    }
    public static function getValueBySlug($slug)
    {
        // Retrieve the setting by slug
        $page = self::where('slug', $slug)->first();
        // dd($page);

        // If the setting exists, return its value, otherwise return null
        return $page ? $page->description : null;
    }

}
