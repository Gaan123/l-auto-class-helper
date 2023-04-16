<?php

use Dada\AutoClassHelper\Tests\TestCase;

uses(TestCase::class)->in(__DIR__);
uses(TestCase::class)
    ->group('feature')
    ->in(__DIR__.'/Feature');
