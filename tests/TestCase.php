<?php

declare(strict_types=1);

namespace Vardanm1993\LaravelAliasManager\Tests;

use Orchestra\Testbench\TestCase as Orchestra;
use Vardanm1993\LaravelAliasManager\LaravelAliasManagerServiceProvider;

abstract class TestCase extends Orchestra
{
    /**
     * @param  \Illuminate\Foundation\Application  $app
     * @return array<int, class-string>
     */
    protected function getPackageProviders($app): array
    {
        return [
            LaravelAliasManagerServiceProvider::class,
        ];
    }
}
