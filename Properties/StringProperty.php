<?php

declare(strict_types=1);

namespace AlastairTelford\Property;

use Attribute;

#[Attribute]
final readonly class StringProperty extends Property
{
    public function get(\ReflectionProperty $rp): \Closure
    {   
        return fn (): string => $rp->getValue($this);
    }   

    public function set(\ReflectionProperty $rp): \Closure
    {   
        return fn (string $v) => $rp->setValue($this, $v);
    }   
}

