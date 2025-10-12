<?php

namespace Database\Factories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ServiceProvider>
 */
class ServiceProviderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $gender = $this->faker->randomElement(['male', 'female', 'unisex']);

        return [
            'name' => substr($this->faker->text(20), 0, -1),
            'contact_email' => '',
            'contact_number' => '',
            'slug' => '',
            'status' => $this->faker->numberBetween(0, 1),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
