<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $first_name = $this->faker->firstName;
        $last_name = $this->faker->lastName;
        $gender = $this->faker->randomElement(['male', 'female', 'other']);

        return [
            'first_name' => $first_name,
            'last_name' => $last_name,
            'email' => $this->faker->unique()->safeEmail(),
            'password' => Hash::make('12345678'), // password
            'remember_token' => Str::random(10),
            'mobile' => $this->faker->phoneNumber,
            'date_of_birth' => $this->faker->date,
            'gender' => $gender,
            'email_verified_at' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
