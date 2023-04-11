<?php

namespace Dada\LAutoClassHelper;

use Dada\LAutoClassHelper\Commands\LAutoClassHelperCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class LAutoClassHelperServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('l-auto-class-helper')
            ->hasConfigFile()
            ->hasViews()
            ->hasMigration('create_l-auto-class-helper_table')
            ->hasCommand(LAutoClassHelperCommand::class);
    }
}
