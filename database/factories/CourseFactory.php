<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CourseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'prefix' => fake()->randomElement(['CS', 'MATH', 'ENG', 'HIST', 'BIO',  'CHEM', 'PHYS', 'ECON', 'PSY', 'ART']),
            'number' => fake()->numberBetween(100, 499),
            'title' => fake()->sentence(3),
            'development_cycle_id' => null,
        ];
    }
}