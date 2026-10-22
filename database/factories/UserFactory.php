<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\User>
 */
class UserFactory extends Factory
{
    protected $model = \App\User::class;

    public function definition(): array
    {
        return [
            'username' => str_replace('.', '', $this->faker->unique()->userName),
            'email' => $this->faker->unique()->safeEmail,
            'password' => 'secret',
            'bio' => $this->faker->sentence,
            'image' => 'https://cdn.worldvectorlogo.com/logos/laravel.svg',
        ];
    }
}
