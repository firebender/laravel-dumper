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
        ksort($constants);

        $display = [];
        foreach ($constants as $key => $value) {
            if (is_array($entry)) {
                $s = "[" . PHP_EOL;
                foreach ($entry as $k => $v) {
                    $s .= "$k => $v" . PHP_EOL;
                }
                $s .= "]" . PHP_EOL;
                $entry = $s;
            }            
            $display[] = "$key => $value";
        }

        return $display;
    }


}
