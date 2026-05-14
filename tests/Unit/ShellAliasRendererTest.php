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
        ->and($block)->toContain('__lam_run()')
        ->and($block)->toContain('# git: Git workflow shortcuts.')
        ->and($block)->toContain("alias gs='__lam_run git status'")
        ->and($block)->toContain("alias gp='__lam_run git push'")
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

    expect($block)->toContain("alias say='__lam_run printf '\\''hello'\\'''");
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
