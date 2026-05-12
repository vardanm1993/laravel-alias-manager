<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Artisan;
use Vardanm1993\LaravelAliasManager\Shell\ShellAliasRenderer;

it('installs selected aliases into an explicit shell file', function (): void {
    $file = tempnam(sys_get_temp_dir(), 'lam-install-');

    $exitCode = Artisan::call('alias-manager:install', [
        'groups' => ['git'],
        '--file' => $file,
        '--no-backup' => true,
    ]);

    $contents = (string) file_get_contents($file);

    expect($exitCode)->toBe(0)
        ->and($contents)->toContain(ShellAliasRenderer::BEGIN_MARKER)
        ->and($contents)->toContain("alias gs='git status'")
        ->and($contents)->not->toContain("alias ci='composer install'");
});

it('fails install for unknown groups', function (): void {
    $file = tempnam(sys_get_temp_dir(), 'lam-install-');

    $exitCode = Artisan::call('alias-manager:install', [
        'groups' => ['missing'],
        '--file' => $file,
        '--no-backup' => true,
    ]);

    expect($exitCode)->toBe(1)
        ->and(Artisan::output())->toContain('Unknown alias group(s): missing');
});
