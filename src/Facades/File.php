<?php

namespace Dada\AutoClassHelper\Facades;

use Illuminate\Support\Facades\Facade;

class File extends Facade
{
    public static function getFacadeAccessor()
    {
        return static::class;
    }
}
