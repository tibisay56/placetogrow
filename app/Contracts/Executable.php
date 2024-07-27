<?php

namespace App\Contracts;

interface Executable
{
    public function execute(array $data): mixed;
}
