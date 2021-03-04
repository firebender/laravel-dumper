<?php

declare(strict_types=1);

namespace FireBender\Laravel\Dumper\Tests\Unit;

use FireBender\Laravel\Dumper\Tests\TestCase;
use FireBender\Laravel\Dumper\Actions\GetClassInterfaces;

use FireBender\Laravel\Dumper\Tests\Artifacts\ClassC;
use FireBender\Laravel\Dumper\Tests\Artifacts\InterfaceA;
use FireBender\Laravel\Dumper\Tests\Artifacts\InterfaceB;
use FireBender\Laravel\Dumper\Tests\Artifacts\InterfaceC;

class GetClassInterfacesTest extends TestCase

{
    /**
     * @test
     * @group skip
     */
    public function can_get_class_interfaces()
    {
        $expected = [
            InterfaceA::class,
            InterfaceB::class,
            InterfaceC::class
        ];

        $object = new ClassC();

        $actual = GetClassInterfaces::run($object);

        $this->assertEquals($expected, $actual);
    }

}