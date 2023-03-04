<?php

namespace App\Services\Dtos;

use JsonSerializable;
use ReflectionClass;
use ReflectionProperty;

abstract class DataTransferObject implements JsonSerializable
{
    public function __construct(array $parameters = [])
    {
        $class = new ReflectionClass(static::class);

        foreach ($class->getProperties(ReflectionProperty::IS_PUBLIC) as $reflectionProperty){
            $property = $reflectionProperty->getName();
            $this->{$property} = $parameters[$property];
        }
    }

    public function jsonSerialize(): mixed
    {
        $class = new ReflectionClass(static::class);

        $result = [];

        foreach ($class->getProperties(ReflectionProperty::IS_PUBLIC) as $reflectionProperty){
            $property = $reflectionProperty->getName();

            if (isset($this->{$property})) {
                $result[$property] = $this->{$property};
            }
        }

        return $result;
    }
}
