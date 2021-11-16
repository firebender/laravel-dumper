<?php

declare(strict_types=1);

namespace FireBender\Laravel\Dumper\Tests\Unit;

use FireBender\Laravel\Dumper\Tests\TestCase;
use FireBender\Laravel\Dumper\Actions\GetClassConstants;

use FireBender\Laravel\Dumper\Tests\Artifacts\ClassD;

class GetClassConstantsTest extends TestCase

{
    /**
     * @test
     * @group skip
     */
    public function can_get_class_constants()
    {
        $expected = [
            'ONE' => 1,
            'TWO' => 2,
            'THREE' => 3,
        ];

        $object = new ClassD();

        $actual = GetClassConstants::run($object);

        $this->assertEquals($expected, $actual);
    }

}