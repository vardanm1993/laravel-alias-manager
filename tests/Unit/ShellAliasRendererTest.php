<?php

declare(strict_types=1);

use Vardanm1993\LaravelAliasManager\Shell\ShellAliasRenderer;

it('renders managed shell alias blocks', function (): void {
    $renderer = new ShellAliasRenderer;

    $block = $renderer->render([
        'git' => [
            'description' => 'Git workflow shortcuts.',
            'aliases' => [
                'gs' => 'git status',
                'gp' => 'git push',
            ],
        ],
    ]);

    expect($block)->toContain(ShellAliasRenderer::BEGIN_MARKER)
        ->and($block)->toContain('# This block is managed by Laravel Alias Manager.')
        ->and($block)->toContain('# Shortcuts run only inside a Laravel project.')
        ->and($block)->toContain('__lam_find_laravel_root()')
        ->and($block)->toContain('[ -f "$dir/bootstrap/app.php" ]')
        ->and($block)->toContain('lamcd()')
        ->and($block)->toContain('__lam_run_cmd()')
        ->and($block)->toContain('# git: Git workflow shortcuts.')
        ->and($block)->toContain('gs() {')
        ->and($block)->toContain("    __lam_run_cmd 'git status' \"\$@\"")
        ->and($block)->toContain('gp() {')
        ->and($block)->toContain("    __lam_run_cmd 'git push' \"\$@\"")
        ->and($block)->toContain('daily() {')
        ->and($block)->toContain(ShellAliasRenderer::END_MARKER)
        ->and($block)->toEndWith(PHP_EOL);
});

it('escapes single quotes in commands', function (): void {
    $renderer = new ShellAliasRenderer;

    $block = $renderer->render([
        'example' => [
            'description' => 'Example aliases.',
            'aliases' => [
                'say' => "printf 'hello'",
            ],
        ],
    ]);

    expect($block)->toContain("    __lam_run_cmd 'printf '\\''hello'\\''' \"\$@\"");
});

it('renders daily favorites', function (): void {
    $renderer = new ShellAliasRenderer;

    $block = $renderer->render([
        'git' => [
            'description' => 'Git aliases.',
            'aliases' => [
                'gst' => 'git status -sb',
            ],
        ],
    ], [
        'gst' => [
            'group' => 'git',
            'command' => 'git status -sb',
        ],
    ]);

    expect($block)->toContain('# daily: User-selected daily favorites.')
        ->and($block)->toContain('lamdaily() {')
        ->and($block)->toContain('    gst || return $?');
});

it('skips groups without aliases', function (): void {
    $renderer = new ShellAliasRenderer;

    $block = $renderer->render([
        'empty' => [
            'description' => 'Empty group.',
            'aliases' => [],
        ],
    ]);

    expect($block)->not->toContain('# empty: Empty group.')
        ->and($block)->toContain(ShellAliasRenderer::BEGIN_MARKER)
        ->and($block)->toContain(ShellAliasRenderer::END_MARKER);
});
