<?php

use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Mis3085\Turso\Database\TursoSchemaGrammar;

beforeEach(function () {
    // The compiled statement differs between Laravel versions (e.g. "PRAGMA foreign_keys = ON;" vs "pragma foreign_keys = 1")
    $this->foreignKeySql = app(TursoSchemaGrammar::class)->compileEnableForeignKeyConstraints();

    $this->pdo = new PDO('sqlite::memory:');
    $this->pdo->exec('CREATE TABLE users (id INTEGER PRIMARY KEY, name TEXT)');
    $this->pdo->exec('INSERT INTO users (name) VALUES ("John Doe")');
    $this->pdo->exec('INSERT INTO users (name) VALUES ("Jane Doe")');

    DB::connection('turso')->setReadPdo($this->pdo);
});

test('it can retrieve data from read replica', function () {
    $users = DB::table('users')->get();

    expect($users)->toHaveCount(2)
        ->and($users[0]->name)->toBe('John Doe')
        ->and($users[1]->name)->toBe('Jane Doe');
})->group('ReadReplicaTest', 'FeatureTest');

test('it will use the primary database connection for data manipulation operation', function () {
    fakeHttpRequest();

    DB::table('users')->insert([
        'name' => 'June Monroe',
    ]);

    Http::assertSent(function (Request $request) {
        expect($request->url())->toBe(config('database.connections.turso.db_url') . '/v3/pipeline')
            ->and($request->data())->toBe([
                'requests' => [
                    [
                        'type' => 'execute',
                        'stmt' => [
                            'sql' => $this->foreignKeySql,
                        ],
                    ],
                    [
                        'type' => 'execute',
                        'stmt' => [
                            'sql'  => 'insert into "users" ("name") values (?)',
                            'args' => [[
                                'type'  => 'text',
                                'value' => 'June Monroe',
                            ]],
                        ],
                    ],
                ],
            ]);

        return true;
    });
})->group('ReadReplicaTest', 'FeatureTest');
