<?php

declare(strict_types=1);

namespace FireBender\Laravel\Dumper\Actions;

use FireBender\Laravel\Dumper\Actions\Concerns\AsObject;
use ReflectionClass;

class GetClassConstants
{
    use AsObject;

    /**
     * 
     */
    public function handle(Object $object)
    {
        $class = new ReflectionClass($object);

        $constants = $class->getConstants();

        return $constants;
    }


}
