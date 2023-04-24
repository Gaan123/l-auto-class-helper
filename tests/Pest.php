<?php

use Dada\AutoClassHelper\Tests\TestCase;

uses(TestCase::class)->in(__DIR__);
uses(TestCase::class)
    ->group('feature')
    ->in(__DIR__.'/Feature');
function accessPrivateOrProtected(object $object, string $method)
{
    $reflection = new \ReflectionClass($object);
    $method = $reflection->getMethod($method);
    $method->setAccessible(true);

    return $method->invoke($object);
}
