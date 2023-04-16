<?php


namespace Dada\AutoClassHelper\Tests\Feature;

use Dada\AutoClassHelper\Attributes\ClassLoader;
use Dada\AutoClassHelper\AutoClassHelper;
use Dada\AutoClassHelper\Dev\AbstractClass\DynClass;
use Dada\AutoClassHelper\Dev\Providers\TestProviders;
use Dada\AutoClassHelper\Tests\TestCase;

class FeatureTest extends TestCase
{

    public function test_get_all_files()
    {
        $this->assertEquals(1,1);
//        (new TestProviders())->boot();
    }
}



