<?php

declare(strict_types=1);

use Vardanm1993\LaravelAliasManager\Aliases\AliasGroupRepository;

it('normalizes configured alias groups', function (): void {
    config()->set('alias-manager.groups', [
        'valid' => [
            'description' => 'Valid aliases.',
            'aliases' => [
                'ok' => 'echo ok',
                10 => 'ignored alias',
                'bad' => 123,
            ],
        ],
        20 => [
            'description' => 'Ignored group.',
            'aliases' => [],
        ],
    ]);

    $groups = app(AliasGroupRepository::class)->all();

    expect($groups)->toHaveKey('valid')
        ->and($groups['valid']['description'])->toBe('Valid aliases.')
        ->and($groups['valid']['aliases'])->toBe(['ok' => 'echo ok']);
});

it('selects only requested groups and reports missing groups', function (): void {
    $repository = app(AliasGroupRepository::class);

    expect($repository->only(['git']))->toHaveKey('git')
        ->and($repository->only(['git']))->not->toHaveKey('composer')
        ->and($repository->missing(['git', 'missing']))->toBe(['missing']);
});
