<?php

declare(strict_types=1);

namespace FireBender\Laravel\Dumper\Actions;

use FireBender\Laravel\Dumper\Actions\Concerns\AsObject;
use ReflectionClass;

class GetClassInterfaces
{
    use AsObject;

    public function handle(Object $object)
    {
        $class = new ReflectionClass($object);

        $arr = $class->getInterfaces();

        if (!count($arr)) return [];

        $interfaces = [];

        foreach ($arr as $interface) {
            $interfaces[] = $interface->getName();
        }

        sort($interfaces);

        return $interfaces;
    }
}
