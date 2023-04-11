<?php

use Dada\LAutoClassHelper\Tests\TestCase;

uses(TestCase::class)->in(__DIR__);
uses(TestCase::class)
    ->group('feature')
    ->in(__DIR__.'/Feature');
