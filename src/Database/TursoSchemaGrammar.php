<?php

declare(strict_types=1);

namespace Mis3085\Turso\Database;

use Illuminate\Database\Schema\Grammars\SQLiteGrammar;
use Override;

class TursoSchemaGrammar extends SQLiteGrammar
{
    public function compileDropAllIndexes(mixed $schema = null): string
    {
        $schema = $this->wrapValue($schema ?? 'main');

        return "SELECT 'DROP INDEX IF EXISTS \"' || name || '\";' FROM {$schema}.sqlite_schema WHERE type = 'index' AND name NOT LIKE 'sqlite_%'";
    }

    public function compileDropAllTables(mixed $schema = null): string
    {
        $schema = $this->wrapValue($schema ?? 'main');

        return "SELECT 'DROP TABLE IF EXISTS \"' || name || '\";' FROM {$schema}.sqlite_schema WHERE type = 'table' AND name NOT LIKE 'sqlite_%'";
    }

    public function compileDropAllTriggers(mixed $schema = null): string
    {
        $schema = $this->wrapValue($schema ?? 'main');

        return "SELECT 'DROP TRIGGER IF EXISTS \"' || name || '\";' FROM {$schema}.sqlite_schema WHERE type = 'trigger' AND name NOT LIKE 'sqlite_%'";
    }

    public function compileDropAllViews(mixed $schema = null): string
    {
        $schema = $this->wrapValue($schema ?? 'main');

        return "SELECT 'DROP VIEW IF EXISTS \"' || name || '\";' FROM {$schema}.sqlite_schema WHERE type = 'view'";
    }

    #[Override]
    public function wrap(mixed $value, mixed $prefixAlias = false): string
    {
        /** @phpstan-ignore arguments.count */
        return str_replace('"', '\'', parent::wrap($value, $prefixAlias));
    }
}
