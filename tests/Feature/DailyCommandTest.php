<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Artisan;

it('shows provided daily favorites', function (): void {
    $exitCode = Artisan::call('alias-manager:daily gst routes');
    $output = Artisan::output();

    expect($exitCode)->toBe(0)
        ->and($output)->toContain('Daily Favorites')
        ->and($output)->toContain('gst')
        ->and($output)->toContain('routes');
});

it('reports empty configured daily favorites', function (): void {
    $exitCode = Artisan::call('alias-manager:daily');

    expect($exitCode)->toBe(0)
        ->and(Artisan::output())->toContain('No daily favorites configured.');
});

it('fails when a daily alias does not exist', function (): void {
    $exitCode = Artisan::call('alias-manager:daily missing');

    expect($exitCode)->toBe(1)
        ->and(Artisan::output())->toContain('Unknown daily alias(es): missing');
});
