<?php

namespace Database\Factories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Comment>
 */
class CommentFactory extends Factory
{
    protected $model = \App\Comment::class;

    /**
     * Each new comment is created one second after the previous one.
     */
    protected static int $reduce = 999;

    public function definition(): array
    {
        return [
            'body' => $this->faker->paragraph($this->faker->numberBetween(1, 5)),
            'user_id' => \App\User::all()->random()->id,
            'created_at' => Carbon::now()->subSeconds(static::$reduce--),
        ];
    }
}
