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
        ->and($contents)->toContain('gs() {')
        ->and($contents)->toContain("    __lam_run_cmd 'git status' \"\$@\"")
        ->and($contents)->not->toContain("    __lam_run_cmd 'composer install' \"\$@\"");
});

it('installs presets with daily favorites', function (): void {
    $file = tempnam(sys_get_temp_dir(), 'lam-install-');

    $exitCode = Artisan::call('alias-manager:install', [
        '--preset' => ['core'],
        '--daily' => ['gst', 'routes'],
        '--file' => $file,
        '--no-backup' => true,
    ]);

    $contents = (string) file_get_contents($file);

    expect($exitCode)->toBe(0)
        ->and($contents)->toContain('gst() {')
        ->and($contents)->toContain('routes() {')
        ->and($contents)->toContain('    gst || return $?')
        ->and($contents)->toContain('    routes || return $?');
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

it('fails install for unknown presets', function (): void {
    $file = tempnam(sys_get_temp_dir(), 'lam-install-');

    $exitCode = Artisan::call('alias-manager:install', [
        '--preset' => ['missing'],
        '--file' => $file,
        '--no-backup' => true,
    ]);

    expect($exitCode)->toBe(1)
        ->and(Artisan::output())->toContain('Unknown preset(s): missing');
});

it('fails install for unknown daily aliases', function (): void {
    $file = tempnam(sys_get_temp_dir(), 'lam-install-');

    $exitCode = Artisan::call('alias-manager:install', [
        'groups' => ['git'],
        '--daily' => ['routes'],
        '--file' => $file,
        '--no-backup' => true,
    ]);

    expect($exitCode)->toBe(1)
        ->and(Artisan::output())->toContain('Unknown daily alias(es): routes');
});
