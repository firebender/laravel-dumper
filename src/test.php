<?php
class Foo
{
    private function __construct()
    {
        echo 'hello';
    }

    static function call()
    {
        new Foo();
    }
}

$foo = Foo::call();