<?php

declare(strict_types=1);

namespace Vardanm1993\LaravelAliasManager;

use Illuminate\Support\ServiceProvider;

final class LaravelAliasManagerServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/alias-manager.php', 'alias-manager');
    }

    public function boot(): void
    {
        if (! $this->app->runningInConsole()) {
            return;
        }

        $this->publishes([
            __DIR__ . '/../config/alias-manager.php' => config_path('alias-manager.php'),
        ], 'alias-manager-config');
    }
}
