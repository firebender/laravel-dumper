<?php

declare(strict_types=1);

namespace FireBender\Laravel\Dumper\Tests\Unit;

use FireBender\Laravel\Dumper\Tests\TestCase;
use FireBender\Laravel\Dumper\Actions\GetClassProperties;

use FireBender\Laravel\Dumper\Tests\Artifacts\ClassC;

class GetClassPropertiesTest extends TestCase

{
    /**
     * @test
     * @group skip
     */
    public function can_get_class_properties()
    {
        $expected = [
            "propertyA" => "public \$propertyA = null",
            "propertyB" => "public \$propertyB = null",
            "propertyC" => "private \$propertyC = null"
        ];

        $object = new ClassC();

        $actual = GetClassProperties::run($object);

        $this->assertEquals($expected, $actual);
    }

}