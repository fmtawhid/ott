<?php

namespace Modules\SEO\database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class SeoFactoryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = \Modules\SEO\Models\SeoFactory::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'slug' => $this->faker->slug,
            'meta_title' => $this->faker->sentence,
            'meta_keywords' => $this->faker->words(5, true),
            'meta_description' => $this->faker->paragraph,
            'seo_image' => $this->faker->imageUrl(),
            'google_site_verification' => $this->faker->word,
            'canonical_url' => $this->faker->url,
            'short_description' => $this->faker->sentence,
        ];
    }
}

