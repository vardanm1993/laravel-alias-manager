<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Artisan;
use Vardanm1993\LaravelAliasManager\Shell\ShellAliasRenderer;

it('previews the rendered shell block', function (): void {
    $exitCode = Artisan::call('alias-manager:preview git');
    $output = Artisan::output();

    expect($exitCode)->toBe(0)
        ->and($output)->toContain(ShellAliasRenderer::BEGIN_MARKER)
        ->and($output)->toContain("alias gs='__lam_run git status'")
        ->and($output)->toContain(ShellAliasRenderer::END_MARKER);
});

it('fails preview for unknown groups', function (): void {
    $exitCode = Artisan::call('alias-manager:preview missing');

    expect($exitCode)->toBe(1)
        ->and(Artisan::output())->toContain('Unknown alias group(s): missing');
});
