<?php

declare(strict_types=1);

namespace FireBender\Laravel\Dumper\Tests\Artifacts;

use FireBender\Laravel\Dumper\Tests\Artifacts\ClassB;

class ClassC extends ClassB implements InterfaceC
{
    use TraitC;

    public $propertyA;

    protected $propertyB;

    private $propertyC;

    public function functionA() {

    }

    protected function functionB() {
        
    }

    private function functionC() {
        
    }
}
