<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

use App\Models\Category; 

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Item>
 */
class ItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */



    public function definition()
    {
        return [
            'name' => $this->faker->word,
            'img' => $this->faker->imageUrl(640, 480, 'items', true),
            // Fetch an existing category or create a new one if none exist
            'category_id' => Category::query()->inRandomOrder()->first()->id ?? Category::factory(),
            'qty' => $this->faker->numberBetween(1, 100),
        ];
    }
}
