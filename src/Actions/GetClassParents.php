<?php

declare(strict_types=1);

namespace FireBender\Laravel\Dumper\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use ReflectionClass;

class GetClassParents
{
    use AsAction;

    public function handle(Object $object)
    {
        $class = new ReflectionClass($object);

        $parents = class_parents($class->name);

        return array_reverse($parents);
    }
}
