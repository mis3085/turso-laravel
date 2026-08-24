<?php

use Illuminate\Process\PendingProcess;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Process;
use Mis3085\Turso\Facades\Turso;
use Mis3085\Turso\Jobs\TursoSyncJob;

test('it can trigger the sync command immediately', function () {
    Process::fake();

    config([
        'database.connections.turso.db_replica' => '/tmp/turso.sqlite',
        'turso-laravel.sync_command.node_path'  => '/dev/null',
    ]);

    DB::connection('turso')->setRecordModificationState(true);

    Turso::sync();

    $dbUrl = config('database.connections.turso.db_url');

    Process::assertRan(function (PendingProcess $process) use ($dbUrl) {
        $expectedPath = realpath(__DIR__ . '/../..');

        expect($process->command)->toBe("/dev/null turso-sync.mjs \"{$dbUrl}\" \"your-access-token\" \"/tmp/turso.sqlite\"")
            ->and($process->timeout)->toBe(60)
            ->and($process->path)->toBe($expectedPath);

        return true;
    });
})->group('TursoManagerTest', 'UnitTest');

test('it can dispatch the sync background job', function () {
    Bus::fake();

    config(['database.connections.turso.db_replica' => '/tmp/turso.sqlite']);

    DB::connection('turso')->setRecordModificationState(true);

    Turso::backgroundSync();

    Bus::assertDispatched(TursoSyncJob::class);
})->group('TursoManagerTest', 'UnitTest');

test('it can run the sync background job and call the sync artisan command', function () {
    Process::fake();

    config([
        'database.connections.turso.db_replica' => '/tmp/turso.sqlite',
        'turso-laravel.sync_command.node_path'  => '/dev/null',
    ]);

    DB::connection('turso')->setRecordModificationState(true);

    Turso::backgroundSync();

    $dbUrl = config('database.connections.turso.db_url');

    Process::assertRan(function (PendingProcess $process) use ($dbUrl) {
        $expectedPath = realpath(__DIR__ . '/../..');

        expect($process->command)->toBe("/dev/null turso-sync.mjs \"{$dbUrl}\" \"your-access-token\" \"/tmp/turso.sqlite\"")
            ->and($process->timeout)->toBe(60)
            ->and($process->path)->toBe($expectedPath);

        return true;
    });
})->group('TursoManagerTest', 'UnitTest');
