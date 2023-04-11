<?php

namespace Dada\LAutoClassHelper\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Dada\LAutoClassHelper\LAutoClassHelper
 */
class LAutoClassHelper extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Dada\LAutoClassHelper\LAutoClassHelper::class;
    }
}
