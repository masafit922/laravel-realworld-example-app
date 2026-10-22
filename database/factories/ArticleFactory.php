<?php

namespace Database\Factories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Article>
 */
class ArticleFactory extends Factory
{
    protected $model = \App\Article::class;

    /**
     * Each new article is created one second after the previous one.
     */
    protected static int $reduce = 999;

    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence,
            'description' => $this->faker->sentence(10),
            'body' => $this->faker->paragraphs($this->faker->numberBetween(1, 3), true),
            'created_at' => Carbon::now()->subSeconds(static::$reduce--),
        ];
    }
}
