<?php

declare(strict_types=1);

namespace FireBender\Laravel\Dumper\Tests\Unit;

use FireBender\Laravel\Dumper\Tests\TestCase;
use FireBender\Laravel\Dumper\Actions\GetClassTraits;

use FireBender\Laravel\Dumper\Tests\Artifacts\ClassC;
use FireBender\Laravel\Dumper\Tests\Artifacts\TraitA;
use FireBender\Laravel\Dumper\Tests\Artifacts\TraitB;
use FireBender\Laravel\Dumper\Tests\Artifacts\TraitC;

class GetClassTraitsTest extends TestCase

{
    /**
     * @test
     * @group skip
     */
    public function can_get_class_traits()
    {
        $expected = [
            TraitA::class => TraitA::class,
            TraitB::class => TraitB::class,
            TraitC::class => TraitC::class,
        ];

        $object = new ClassC();

        $actual = GetClassTraits::run($object);

        $this->assertEquals($expected, $actual);
    }

}