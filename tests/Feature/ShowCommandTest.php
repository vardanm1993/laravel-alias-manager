<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Artisan;

it('shows aliases for a specific group', function (): void {
    $exitCode = Artisan::call('alias-manager:show git');
    $output = Artisan::output();

    expect($exitCode)->toBe(0)
        ->and($output)->toContain('Alias Group: git')
        ->and($output)->toContain('Daily Git workflow shortcuts.')
        ->and($output)->toContain('gs')
        ->and($output)->toContain('git status')
        ->and($output)->toContain('gp')
        ->and($output)->toContain('git push');
});

it('fails when the group does not exist', function (): void {
    $exitCode = Artisan::call('alias-manager:show missing');
    $output = Artisan::output();

    expect($exitCode)->toBe(1)
        ->and($output)->toContain('Alias group [missing] was not found.');
});
