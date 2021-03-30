<?php

declare(strict_types=1);

namespace FireBender\Laravel\Dumper\Actions;

use FireBender\Laravel\Dumper\Actions\Concerns\AsObject;
use FireBender\Laravel\Dumper\Dumper;
use ReflectionClass;

class GetClassProperties
{
    use AsObject;

    public function handle(Object $object)
    {
        $class = new ReflectionClass($object);

        $arr = $class->getProperties();

        if (!count($arr)) return [];

        $properties = [];
        foreach ($arr as $property)
        {
            $name = $property->getName();

            if ($name === 'macros') $this->flag = true;

            $modifier = '';
            $modifier .= $property->isPrivate() ? 'private ' : 'public ';
            $modifier .= $property->isStatic() ? 'static ' : '' ;

            $type = '';
            if ($property->hasType())
            {
                $type = $property->getType() . ' ';

            }

            $property->setAccessible(true);

            $default = '';
            $value = $property->getValue($object);

            $value = Dumper::getDump($value);
            $default .= ' = ' . $value;

            $properties[$name] = $modifier . $type . '$' . $name . $default;
        }

        ksort($properties);

        return $properties;
    }
}
