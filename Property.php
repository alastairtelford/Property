<?php

declare(strict_types = 1);

namespace AlastairTelford\Property;

use Attribute;

use AlastairTelford\Property\PropertyAccess;

#[Attribute]
abstract readonly class Property implements PropertyAccess
{
    public function __construct(
        public readonly string $propN = '', 
        public readonly string $getMN = '', 
        public readonly string $setMN = ''
    ) {}

    abstract public function get(\ReflectionProperty $rp): \Closure;

    abstract public function set(\ReflectionProperty $rp): \Closure;
}
