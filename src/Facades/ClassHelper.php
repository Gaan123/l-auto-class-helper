<?php

namespace Dada\AutoClassHelper\Facades;

use Illuminate\Support\Facades\Facade;

class ClassHelper extends Facade
{
    public static function getFacadeAccessor()
    {
        return static::class;
    }
}
