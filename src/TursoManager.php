<?php

declare(strict_types=1);

namespace Mis3085\Turso;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Mis3085\Turso\Jobs\TursoSyncJob;

class TursoManager
{
    public function backgroundSync(): void
    {
        collect((array) config('database.connections'))
            ->filter(fn ($config) => $config['driver'] === 'turso')
            ->filter(fn ($config) => (string) $config['db_replica'] !== '')
            ->each(function ($config, $connectionName) {
                if (DB::connection($connectionName)->hasModifiedRecords()) {
                    TursoSyncJob::dispatch($connectionName);
                }
            });
    }

    public function sync(): void
    {
        collect((array) config('database.connections'))
            ->filter(fn ($config) => $config['driver'] === 'turso')
            ->filter(fn ($config) => (string) $config['db_replica'] !== '')
            ->each(function ($config, $connectionName) {
                if (DB::connection($connectionName)->hasModifiedRecords()) {
                    Artisan::call('turso:sync', ['connectionName' => $connectionName]);
                }
            });
    }
}
