<?php

namespace Database\Factories;

use App\Models\Joob;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Joob>
 */
class JoobFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->jobTitle,
            'description' => fake()->paragraph(6),
            'salary' => fake()->numberBetween(5_000,150_000),
            'location' => fake()->city,
            'category' => fake()->randomElement(Joob::$category),
            'experience' => fake()->randomElement(Joob::$experience)
        ];
    }
}
