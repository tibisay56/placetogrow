<?php

namespace App\Context;

use App\Strategies\SettingsStrategy;

class SettingsContext
{
    private SettingsStrategy $strategy;

    public function __construct(SettingsStrategy $strategy)
    {
        $this->strategy = $strategy;
    }

    public function setStrategy(SettingsStrategy $strategy): void
    {
        $this->strategy = $strategy;
    }

    public function getFields(): array
    {
        return $this->strategy->getFields();
    }

    public function getExpirationTime(): int
    {
        return $this->strategy->getExpirationTime();
    }
}
