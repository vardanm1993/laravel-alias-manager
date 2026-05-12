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
        ->and($block)->toContain('# git: Git workflow shortcuts.')
        ->and($block)->toContain("alias gs='git status'")
        ->and($block)->toContain("alias gp='git push'")
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

    expect($block)->toContain("alias say='printf '\\''hello'\\'''");
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
