<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'title' => $this->faker->randomElement(['Transportation Vehicle', 'Folklore Costumes, Equipments & Musical Instruments', 'Event Venues', ]),
            'approval' => $this->faker->randomElement(['1', '2', '3']),
        ];
    }
}
