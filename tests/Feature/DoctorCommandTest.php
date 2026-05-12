<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Artisan;

it('reports package readiness', function (): void {
    $file = tempnam(sys_get_temp_dir(), 'lam-doctor-');

    $exitCode = Artisan::call('alias-manager:doctor', [
        '--file' => $file,
    ]);
    $output = Artisan::output();

    expect($exitCode)->toBe(0)
        ->and($output)->toContain('Laravel Alias Manager Doctor')
        ->and($output)->toContain('Alias groups')
        ->and($output)->toContain($file);
});
