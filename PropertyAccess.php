<?php

declare(strict_types=1);

namespace AlastairTelford\Property;

interface PropertyAccess
{
    public function get(\ReflectionProperty $rp): \Closure;
    public function set(\ReflectionProperty $rp): \Closure;
}
