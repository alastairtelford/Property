<?php

declare(strict_types = 1);

namespace AlastairTelford\Property;

use AlastairTelford\Property\PropertyResolver;

trait PropertyHelper
{
    public function __set(string $p, mixed $v): void
    {   
        $props = PropertyResolver::factory()->resolve($this);
        if (array_key_exists($p, $props)) {
            $method = $props[$p]['set'];
            $method->call($this, $v);
        } else {
            throw new \ErrorException("Property {$p} does not exist");
        }   
    }   

    public function __get(string $p): mixed
    {   
        $props = PropertyResolver::factory()->resolve($this);
        if (array_key_exists($p, $props)) {
            $method = $props[$p]['get'];
            return $method->call($this);
        }   

        throw new \ErrorException("Property {$p} does not exist");
    }   

    /** 
     * @param array<mixed> $v
     */
    public function __call(string $m, array $v): mixed
    {   
        $props = PropertyResolver::factory()->resolve($this);
        if (array_key_exists($m, $props)) {
            $method = $props[$m];

            return $method->call($this, ...$v);
        }   

        throw new \ErrorException("Method {$m} does not exist");
    }   
}
