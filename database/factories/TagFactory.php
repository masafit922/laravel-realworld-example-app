<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Tag>
 */
class TagFactory extends Factory
{
    protected $model = \App\Tag::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->unique()->word,
        ];
    }
}
