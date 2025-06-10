<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class PostFactory extends Factory
{
    public function definition(): array
    {
        return [
            'header' => $this->faker->sentence,
            'content' => $this->faker->paragraph,
            'hotness' => $this->faker->numberBetween(0, 100),
        ];
    }
}
