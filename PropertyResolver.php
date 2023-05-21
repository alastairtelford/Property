<?php

declare(strict_types=1);

namespace AlastairTelford\Property;

final class PropertyResolver
{
    static private ?self $instance = null;

    public function __construct(
        private array $class_properties = []
    ) {}

    static public function factory(): self
    {
        self::$instance ??= new self(); 

        return self::$instance;
    }

    /** 
     * @return array<string, Closure|array{get:Closure, set:Closure}>
     */
    public function resolve(object $subject): array
    {   
        if (!array_key_exists($subject::class, $this->class_properties)) {
            $rc = new \ReflectionClass($subject);
            $props = $rc->getProperties();
            $this->class_properties[$subject::class]= []; 
            foreach ($props as $p) {
                $this->class_properties[$subject::class] = array_merge($this->class_properties[$subject::class], $this->resolveProperty($p));
            }   
        }

        return $this->class_properties[$subject::class];
    }   

    /** 
     * @return array<string, Closure|array{get:Closure, set:Closure}>
     */
    public function resolveProperty(\ReflectionProperty $p): array
    {
        $get_set_props = [];
        $attributes = $p->getAttributes(Property::class, \ReflectionAttribute::IS_INSTANCEOF);
        foreach ($attributes as $attr) {
            $get_set_props = array_merge($get_set_props, $this->resolveFromAttribute($p, $attr));
        }   

        return $get_set_props;
    }

    /** 
     * @return array<string, Closure|array{get:Closure, set:Closure}>
     */
    public function resolveFromAttribute(\ReflectionProperty $p, \ReflectionAttribute $attr): array
    {
        $get_set_props = [];
        $obj = $attr->newInstance();
        $get_set_props[$obj->propN] = ['get' => $obj->get($p), 'set' => $obj->set($p)];
        $get_set_props[$obj->getMN] = $obj->get($p);
        $get_set_props[$obj->setMN] = $obj->set($p);

        return $get_set_props;
    }
}
