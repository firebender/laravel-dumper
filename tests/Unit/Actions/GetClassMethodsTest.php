<?php

declare(strict_types=1);

namespace FireBender\Laravel\Dumper\Tests\Unit;

use FireBender\Laravel\Dumper\Tests\TestCase;
use FireBender\Laravel\Dumper\Actions\GetClassMethods;

use FireBender\Laravel\Dumper\Tests\Artifacts\ClassC;

class GetClassMethodsTest extends TestCase

{
    /**
     * @test
     * @group skip
     */
    public function can_get_class_methods()
    {
        $expected = [
            'functionA' => 'functionA()',
            'functionB' => 'protected functionB()',
            'functionC' => 'private functionC()',
        ];

        $object = new ClassC();

        $actual = GetClassMethods::run($object);

        $this->assertEquals($expected, $actual);
    }

}