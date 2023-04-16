<?php

namespace Dada\AutoClassHelper\Traits;

trait Observable
{
    public static function bootObservable()
    {
        $modelName = class_basename(static::class);
        $baseNamespace = substr(static::class, 0, strpos(static::class, '\Models'));
        $observerClass = "$baseNamespace\\Observers\\{$modelName}Observer";
        if (! class_exists($observerClass)) {
        return;
        }
        (new static())->registerObserver($observerClass);
    }
}
