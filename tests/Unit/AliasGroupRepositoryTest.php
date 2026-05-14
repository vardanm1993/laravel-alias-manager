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

it('normalizes presets and resolves preset groups', function (): void {
    config()->set('alias-manager.presets', [
        'valid' => [
            'description' => 'Valid preset.',
            'groups' => ['git', 'artisan', 123],
        ],
        10 => [
            'description' => 'Ignored preset.',
            'groups' => [],
        ],
    ]);

    $repository = app(AliasGroupRepository::class);

    expect($repository->presets())->toHaveKey('valid')
        ->and($repository->presets()['valid']['groups'])->toBe(['git', 'artisan'])
        ->and($repository->missingPresets(['valid', 'missing']))->toBe(['missing'])
        ->and($repository->groupNames(['composer'], ['valid']))->toBe(['composer', 'git', 'artisan']);
});

it('searches aliases and resolves daily favorites', function (): void {
    $repository = app(AliasGroupRepository::class);
    $matches = $repository->search('route');

    expect($matches)->not->toBeEmpty()
        ->and($matches[0])->toHaveKeys(['alias', 'group', 'command'])
        ->and($repository->daily(['gst'], ['git']))->toHaveKey('gst')
        ->and($repository->missingDailyAliases(['routes'], ['git']))->toBe(['routes']);
});
