<?php

namespace App\Strategies;

interface SettingsStrategy
{
    public function getFields(): array;

    public function getExpirationTime(): int;
}
