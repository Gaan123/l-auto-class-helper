<?php

namespace Dada\AutoClassHelper\Tests\Feature;

use Dada\AutoClassHelper\Dev\Providers\TestProviders;
use Dada\AutoClassHelper\Facades\ClassHelper;
use Dada\AutoClassHelper\Interfaces\Test;
use Dada\AutoClassHelper\Tests\TestCase;
use Illuminate\Support\Facades\Facade;

class FeatureTest extends TestCase
{
    public function test_get_all_files()
    {
        $this->assertEquals(1, 1);
//        (new TestProviders())->boot();

    }
}
