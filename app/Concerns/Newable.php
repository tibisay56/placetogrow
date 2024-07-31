<?php

namespace App\Concerns;

trait Newable
{
    public static function new(mixed ...$args): static
    {
        return new static(...$args);
    }
}
