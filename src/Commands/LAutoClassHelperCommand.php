<?php

namespace Dada\LAutoClassHelper\Commands;

use Illuminate\Console\Command;

class LAutoClassHelperCommand extends Command
{
    public $signature = 'l-auto-class-helper';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
