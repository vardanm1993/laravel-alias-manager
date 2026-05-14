<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Artisan;

it('searches aliases by query', function (): void {
    $exitCode = Artisan::call('alias-manager:search route');
    $output = Artisan::output();

    expect($exitCode)->toBe(0)
        ->and($output)->toContain('Alias Search: route')
        ->and($output)->toContain('routes')
        ->and($output)->toContain('php artisan route:list');
});

it('reports empty search results', function (): void {
    $exitCode = Artisan::call('alias-manager:search definitely-missing-alias');

    expect($exitCode)->toBe(0)
        ->and(Artisan::output())->toContain('No aliases matched [definitely-missing-alias].');
});
