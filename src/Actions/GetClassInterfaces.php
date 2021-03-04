<?php

declare(strict_types=1);

namespace FireBender\Laravel\Dumper\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use ReflectionClass;

class GetClassInterfaces
{
    use AsAction;

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
