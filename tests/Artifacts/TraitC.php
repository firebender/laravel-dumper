<?php

declare(strict_types=1);

namespace FireBender\Laravel\Dumper\Tests\Artifacts;

use FireBender\Laravel\Dumper\Tests\Artifacts\TraitB;

trait TraitC
{
    use TraitA, TraitB;
}
