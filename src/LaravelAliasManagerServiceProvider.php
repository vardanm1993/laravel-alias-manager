<?php

declare(strict_types=1);

namespace Vardanm1993\LaravelAliasManager;

use Illuminate\Support\ServiceProvider;
use Vardanm1993\LaravelAliasManager\Commands\AboutCommand;
use Vardanm1993\LaravelAliasManager\Commands\DailyCommand;
use Vardanm1993\LaravelAliasManager\Commands\DoctorCommand;
use Vardanm1993\LaravelAliasManager\Commands\InstallCommand;
use Vardanm1993\LaravelAliasManager\Commands\ListCommand;
use Vardanm1993\LaravelAliasManager\Commands\PresetsCommand;
use Vardanm1993\LaravelAliasManager\Commands\PreviewCommand;
use Vardanm1993\LaravelAliasManager\Commands\SearchCommand;
use Vardanm1993\LaravelAliasManager\Commands\ShowCommand;
use Vardanm1993\LaravelAliasManager\Commands\UninstallCommand;
use Vardanm1993\LaravelAliasManager\Shell\ShellAliasRenderer;
use Vardanm1993\LaravelAliasManager\Shell\ShellProfileManager;

final class LaravelAliasManagerServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/alias-manager.php', 'alias-manager');

        $this->app->singleton(ShellAliasRenderer::class);
        $this->app->singleton(ShellProfileManager::class);
    }

    public function boot(): void
    {
        if (! $this->app->runningInConsole()) {
            return;
        }

        $this->publishes([
            __DIR__.'/../config/alias-manager.php' => config_path('alias-manager.php'),
        ], 'alias-manager-config');

        $this->commands([
            AboutCommand::class,
            DailyCommand::class,
            DoctorCommand::class,
            InstallCommand::class,
            ListCommand::class,
            PresetsCommand::class,
            PreviewCommand::class,
            SearchCommand::class,
            ShowCommand::class,
            UninstallCommand::class,
        ]);
    }
}
