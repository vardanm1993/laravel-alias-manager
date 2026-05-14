<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Artisan;
use Vardanm1993\LaravelAliasManager\Shell\ShellAliasRenderer;

it('previews the rendered shell block', function (): void {
    $exitCode = Artisan::call('alias-manager:preview git');
    $output = Artisan::output();

    expect($exitCode)->toBe(0)
        ->and($output)->toContain(ShellAliasRenderer::BEGIN_MARKER)
        ->and($output)->toContain('gs() {')
        ->and($output)->toContain("    __lam_run_cmd 'git status' \"\$@\"")
        ->and($output)->toContain(ShellAliasRenderer::END_MARKER);
});

it('previews presets and daily favorites', function (): void {
    $exitCode = Artisan::call('alias-manager:preview --preset=core --daily=gst --daily=routes');
    $output = Artisan::output();

    expect($exitCode)->toBe(0)
        ->and($output)->toContain('gst() {')
        ->and($output)->toContain('routes() {')
        ->and($output)->toContain('    gst || return $?')
        ->and($output)->toContain('    routes || return $?');
});

it('fails preview for unknown groups', function (): void {
    $exitCode = Artisan::call('alias-manager:preview missing');

    expect($exitCode)->toBe(1)
        ->and(Artisan::output())->toContain('Unknown alias group(s): missing');
});

it('fails preview for unknown presets', function (): void {
    $exitCode = Artisan::call('alias-manager:preview --preset=missing');

    expect($exitCode)->toBe(1)
        ->and(Artisan::output())->toContain('Unknown preset(s): missing');
});
