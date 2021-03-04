<?php

declare(strict_types=1);

namespace FireBender\Laravel\Dumper\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use ReflectionClass;

class GetClassTraits
{
    use AsAction;

    /**
     * 
     */
    public function handle(Object $object)
    {
        $class = new ReflectionClass($object);

        $traits = $this->class_uses_deep($class->name);

        return $traits;
    }

    /**
     * Gets all traits a class uses, including those of parents'
     * 
     * https://www.php.net/manual/en/function.class-uses.php#110752
     */
    protected function class_uses_deep($class, $autoload = true) 
    {
        $traits = [];
        
        do {
            $traits = array_merge(class_uses($class, $autoload), $traits);
        } while($class = get_parent_class($class));

        foreach ($traits as $trait => $same) {
            $traits = array_merge(class_uses($trait, $autoload), $traits);
        }
        
        return array_unique($traits);
    }

}
