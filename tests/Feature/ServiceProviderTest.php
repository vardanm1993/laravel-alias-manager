<?php

declare(strict_types=1);

use Vardanm1993\LaravelAliasManager\LaravelAliasManagerServiceProvider;

it('registers the package service provider', function (): void {
    expect($this->app->providerIsLoaded(LaravelAliasManagerServiceProvider::class))->toBeTrue();
});

it('loads the package configuration', function (): void {
    expect(config('alias-manager.shells'))->toBe(['bash', 'zsh'])
        ->and(config('alias-manager.backup'))->toBeTrue();
});
