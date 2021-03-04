<?php

declare(strict_types=1);

namespace FireBender\Laravel\Dumper\Tests\Unit;

use FireBender\Laravel\Dumper\Tests\TestCase;
use FireBender\Laravel\Dumper\Actions\GetClassParents;

use FireBender\Laravel\Dumper\Tests\Artifacts\ClassA;
use FireBender\Laravel\Dumper\Tests\Artifacts\ClassB;
use FireBender\Laravel\Dumper\Tests\Artifacts\ClassC;

class GetClassParentsTest extends TestCase

{
    /**
     * @test
     * @group skip
     */
    public function can_get_class_parents()
    {
        $expected = [
            ClassA::class => ClassA::class,
            ClassB::class => ClassB::class
        ];

        $object = new ClassC();

        $actual = GetClassParents::run($object);

        $this->assertEquals($expected, $actual);
    }

}