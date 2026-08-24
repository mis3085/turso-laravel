<?php

declare(strict_types=1);

namespace Mis3085\Turso\Tests\Fixtures\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Mis3085\Turso\Tests\Fixtures\Models\Phone;
use Mis3085\Turso\Tests\Fixtures\Models\User;

class PhoneFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id'      => User::factory(),
            'phone_number' => fake()->phoneNumber(),
        ];
    }

    public function modelName(): string
    {
        return Phone::class;
    }
}
