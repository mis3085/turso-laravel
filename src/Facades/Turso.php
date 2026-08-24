<?php

declare(strict_types=1);

namespace Mis3085\Turso\Facades;

use Illuminate\Support\Facades\Facade;
use Mis3085\Turso\TursoManager;

/**
 * @see TursoManager
 *
 * @mixin TursoManager
 */
class Turso extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return TursoManager::class;
    }
}
