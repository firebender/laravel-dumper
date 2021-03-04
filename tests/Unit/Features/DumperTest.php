<?php

declare(strict_types=1);

namespace FireBender\Laravel\Dumper\Tests\Unit;

use FireBender\Laravel\Dumper\Tests\TestCase;
use FireBender\Laravel\Dumper\Dumper;
use Illuminate\Testing\Assert;
use Route;

class DumperTest extends TestCase

{
    /**
     * @test
     * @group skip
     */
    public function can_get_bindings()
    {
        $expected = [
            'Faker\Generator',
            'Illuminate\Auth\Middleware\RequirePassword',
            'Illuminate\Broadcasting\BroadcastManager',
            'Illuminate\Bus\BatchRepository',
            'Illuminate\Bus\DatabaseBatchRepository',
            'Illuminate\Bus\Dispatcher',
            'Illuminate\Cache\RateLimiter',
            'Illuminate\Console\Scheduling\Schedule',
        ];

        $actual = d()->bindings(true);

        $message = 'Not found';
        Assert::assertArraySubset($expected, $actual, true, $message);
    }

    /**
     * @test
     * @group skip
     */
    public function can_get_loaded_providers()
    {
        $expected = [
            "Illuminate\Auth\AuthServiceProvider",
            "Illuminate\Auth\Passwords\PasswordResetServiceProvider",
            "Illuminate\Broadcasting\BroadcastServiceProvider",
            "Illuminate\Bus\BusServiceProvider",
            "Illuminate\Cache\CacheServiceProvider",
            "Illuminate\Cookie\CookieServiceProvider",
            "Illuminate\Database\DatabaseServiceProvider",
            "Illuminate\Database\MigrationServiceProvider",
            "Illuminate\Encryption\EncryptionServiceProvider",
            "Illuminate\Events\EventServiceProvider",
            "Illuminate\Filesystem\FilesystemServiceProvider",
        ];

        $actual = d()->providers(true);

        $message = 'Not found';
        Assert::assertArraySubset($expected, $actual, true, $message);
    }

    /**
     * @test
     * @group skip
     */
    public function can_get_commands()
    {
        $expected = [
            "auth:clear-resets",
            "cache:clear",
            "cache:forget",
            "cache:table",
            "clear-compiled",
            "config:cache",
            "config:clear",
            "db",
            "db:seed",
            "db:wipe",
            "down",
            "env",
        ];

        $actual = d()->commands(true);

        $message = 'Not found';
        Assert::assertArraySubset($expected, $actual, true, $message);
    }

    /**
     * @test
     * @group skip
     */
    public function can_get_routes()
    {
        Route::addRoute('GET', '/', function(){});
        Route::addRoute('PATCH', 'api/v3/post-data', 
            ['SomeNamespace\SomeController', 'patchData'])->name('api.v3.patch-data');
        Route::addRoute('POST', 'register', function (){})->name('register');

        $expected = [
            'Route # 1' => ['action' => 'Closure', 'uri' => '/'],
            'api.v3.patch-data' => ['action' => 'SomeNamespace\SomeController@patchData', 'uri' => 'api/v3/post-data'],
            'register' => ['action' => 'Closure', 'uri' => 'register'],
        ];

        $actual = d()->routes(true);

        $this->assertEquals($expected, $actual);
    }

}