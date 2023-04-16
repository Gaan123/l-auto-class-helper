<?php

namespace Dada\AutoClassHelper\Attributes;

use Attribute;

#[Attribute]
class ClassLoader
{
    public function __construct(public string $abstractClassPath = '', public string $abstractClassnameSpace = '')
    {
    }
}
