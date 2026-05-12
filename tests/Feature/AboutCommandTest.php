<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Artisan;

it('displays package information', function (): void {
    $exitCode = Artisan::call('alias-manager:about');
    $output = Artisan::output();

    expect($exitCode)->toBe(0)
        ->and($output)->toContain('Laravel Alias Manager')
        ->and($output)->toContain('vardanm1993/laravel-alias-manager')
        ->and($output)->toContain('dev-main')
        ->and($output)->toContain('Manage Laravel and PHP workflow aliases safely.');
});
