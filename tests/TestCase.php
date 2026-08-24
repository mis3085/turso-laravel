<?php

namespace Mis3085\Turso\Tests;

use Illuminate\Database\Eloquent\Factories\Factory;
use Mis3085\Turso\TursoLaravelServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();

        Factory::guessFactoryNamesUsing(
            fn (string $modelName) => 'Mis3085\\Turso\\Tests\\Fixtures\\Factories\\' . class_basename($modelName) . 'Factory'
        );
    }

    protected function getPackageProviders($app)
    {
        return [
            TursoLaravelServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app)
    {
        config()->set('database.connections.turso', [
            'driver'                  => 'turso',
            'db_url'                  => env('TURSO_DB_URL', 'http://127.0.0.1:8080'),
            'db_replica'              => env('DB_REPLICA'),
            'prefix'                  => env('DB_PREFIX', ''),
            'access_token'            => 'your-access-token',
            'foreign_key_constraints' => env('DB_FOREIGN_KEYS', true),
            'sticky'                  => env('DB_STICKY', true),
        ]);
        config()->set('database.default', 'turso');
        config()->set('queue.default', 'sync');
    }
}
