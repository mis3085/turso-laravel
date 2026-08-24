<?php

declare(strict_types=1);

namespace Mis3085\Turso\Contracts;

use Illuminate\Contracts\Support\Arrayable;
use Stringable;

interface TursoQuery extends Arrayable, Stringable
{
    public function getIndex(): int;

    public function getType(): string;

    public function setIndex(int $index): self;
}
