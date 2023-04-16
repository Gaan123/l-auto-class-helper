<?php

namespace Dada\AutoClassHelper\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Dada\AutoClassHelper\AutoClassHelper
 */
class AutoClassHelper extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Dada\AutoClassHelper\AutoClassHelper::class;
    }
}
