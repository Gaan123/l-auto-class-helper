<?php

namespace Dada\AutoClassHelper\Traits;

trait Observable
{
    public static function bootObservable()
    {
        $observerClass = static::hasObserver();
        if ($observerClass) {
            (new static())->registerObserver($observerClass);

        return true;
        }

        return false;

    }

    private static function hasObserver(): bool|string
    {
        $modelName = class_basename(static::class);
        $baseNamespace = substr(static::class, 0, strpos(static::class, '\Models'));
        $observerClass = "$baseNamespace\\Observers\\{$modelName}Observer";

        return class_exists($observerClass) ? $observerClass : false;
    }
}
