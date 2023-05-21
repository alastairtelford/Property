<?php

declare(strict_types=1);

namespace AlastairTelford\Property;

use Attribute;

use AlastairTelford\Property\Property;

#[Attribute]
final readonly class DefaultProperty extends Property
{
    public function get(\ReflectionProperty $rp): \Closure
    {   
        return fn (): mixed => $rp->getValue($this);
    }   

    public function set(\ReflectionProperty $rp): \Closure
    {   
        return fn (mixed $v) => $rp->setValue($this, $v);
    }   
}
