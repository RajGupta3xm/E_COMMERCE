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
        'name' => $this->faker->words(2, true),
        'slug' => $this->faker->slug,
        'description' => $this->faker->paragraph,
        'is_active' => $this->faker->boolean(90),
        'parent_id' => null,
        'order' => $this->faker->numberBetween(0, 100)
    ];
}
}
