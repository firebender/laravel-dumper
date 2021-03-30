<?php

declare(strict_types=1);

namespace FireBender\Laravel\Dumper\Actions;

use FireBender\Laravel\Dumper\Actions\Concerns\AsObject;
use ReflectionClass;

class GetClassParents
{
    use AsObject;

    public function handle(Object $object)
    {
        $class = new ReflectionClass($object);

        $parents = class_parents($class->name);

        return array_reverse($parents);
    }
}
