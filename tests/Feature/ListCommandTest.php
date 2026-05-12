<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Artisan;

it('lists available alias groups', function (): void {
    $exitCode = Artisan::call('alias-manager:list');
    $output = Artisan::output();

    expect($exitCode)->toBe(0)
        ->and($output)->toContain('Available Alias Groups')
        ->and($output)->toContain('system')
        ->and($output)->toContain('git')
        ->and($output)->toContain('composer')
        ->and($output)->toContain('artisan')
        ->and($output)->toContain('sail')
        ->and($output)->toContain('npm');
});
