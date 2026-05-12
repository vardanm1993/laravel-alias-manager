<?php

declare(strict_types=1);

use Vardanm1993\LaravelAliasManager\Shell\ShellAliasRenderer;
use Vardanm1993\LaravelAliasManager\Shell\ShellProfileManager;

it('installs a managed block into a shell file', function (): void {
    $file = tempnam(sys_get_temp_dir(), 'lam-shell-');
    file_put_contents($file, 'export PATH="$HOME/bin:$PATH"'.PHP_EOL);

    app(ShellProfileManager::class)->install($file, [
        'git' => [
            'description' => 'Git aliases.',
            'aliases' => ['gs' => 'git status'],
        ],
    ], backup: false);

    $contents = file_get_contents($file);

    expect($contents)->toContain('export PATH=')
        ->and($contents)->toContain(ShellAliasRenderer::BEGIN_MARKER)
        ->and($contents)->toContain("alias gs='git status'");
});

it('replaces an existing managed block instead of duplicating it', function (): void {
    $file = tempnam(sys_get_temp_dir(), 'lam-shell-');
    $manager = app(ShellProfileManager::class);

    $manager->install($file, [
        'git' => [
            'description' => 'Git aliases.',
            'aliases' => ['gs' => 'git status'],
        ],
    ], backup: false);

    $manager->install($file, [
        'composer' => [
            'description' => 'Composer aliases.',
            'aliases' => ['ci' => 'composer install'],
        ],
    ], backup: false);

    $contents = (string) file_get_contents($file);

    expect(substr_count($contents, ShellAliasRenderer::BEGIN_MARKER))->toBe(1)
        ->and($contents)->toContain("alias ci='composer install'")
        ->and($contents)->not->toContain("alias gs='git status'");
});

it('uninstalls only the managed block', function (): void {
    $file = tempnam(sys_get_temp_dir(), 'lam-shell-');
    $manager = app(ShellProfileManager::class);

    file_put_contents($file, 'export EDITOR=vim'.PHP_EOL);

    $manager->install($file, [
        'git' => [
            'description' => 'Git aliases.',
            'aliases' => ['gs' => 'git status'],
        ],
    ], backup: false);

    $removed = $manager->uninstall($file, backup: false);
    $contents = (string) file_get_contents($file);

    expect($removed)->toBeTrue()
        ->and($contents)->toContain('export EDITOR=vim')
        ->and($contents)->not->toContain(ShellAliasRenderer::BEGIN_MARKER);
});
