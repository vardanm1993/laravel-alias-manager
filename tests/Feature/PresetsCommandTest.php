<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Artisan;

it('lists available presets', function (): void {
    $exitCode = Artisan::call('alias-manager:presets');
    $output = Artisan::output();

    expect($exitCode)->toBe(0)
        ->and($output)->toContain('Available Alias Presets')
        ->and($output)->toContain('core')
        ->and($output)->toContain('fullstack')
        ->and($output)->toContain('pro');
});

it('shows a specific preset', function (): void {
    $exitCode = Artisan::call('alias-manager:presets core');
    $output = Artisan::output();

    expect($exitCode)->toBe(0)
        ->and($output)->toContain('Alias Preset: core')
        ->and($output)->toContain('git')
        ->and($output)->toContain('artisan');
});

it('fails when the preset does not exist', function (): void {
    $exitCode = Artisan::call('alias-manager:presets missing');

    expect($exitCode)->toBe(1)
        ->and(Artisan::output())->toContain('Alias preset [missing] was not found.');
});
