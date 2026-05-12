<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Artisan;
use Vardanm1993\LaravelAliasManager\Shell\ShellAliasRenderer;

it('removes the managed alias block from an explicit shell file', function (): void {
    $file = tempnam(sys_get_temp_dir(), 'lam-uninstall-');

    Artisan::call('alias-manager:install', [
        'groups' => ['git'],
        '--file' => $file,
        '--no-backup' => true,
    ]);

    $exitCode = Artisan::call('alias-manager:uninstall', [
        '--file' => $file,
        '--no-backup' => true,
    ]);

    expect($exitCode)->toBe(0)
        ->and((string) file_get_contents($file))->not->toContain(ShellAliasRenderer::BEGIN_MARKER);
});
