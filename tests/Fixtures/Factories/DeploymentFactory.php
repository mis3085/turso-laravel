<?php

declare(strict_types=1);

namespace Mis3085\Turso\Tests\Fixtures\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Mis3085\Turso\Tests\Fixtures\Models\Deployment;
use Mis3085\Turso\Tests\Fixtures\Models\Environment;

class DeploymentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'environment_id' => Environment::factory(),
            'commit_hash'    => sha1(Str::random(40)),
        ];
    }

    public function modelName(): string
    {
        return Deployment::class;
    }
}
