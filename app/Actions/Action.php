<?php

namespace App\Actions;

use App\Concerns\Newable;
use App\Contracts\Executable;

abstract class Action implements Executable
{
    use Newable;
}
