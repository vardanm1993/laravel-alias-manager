<?php

declare(strict_types=1);

namespace Vardanm1993\LaravelAliasManager\Commands;

use Illuminate\Console\Command;

final class ListCommand extends Command
{
    protected $signature = 'alias-manager:list';

    protected $description = 'List available Laravel Alias Manager alias groups.';

    public function handle(): int
    {
        $groups = $this->aliasGroups();

        $this->components->info('Available Alias Groups');

        $this->table(
            ['Group', 'Aliases', 'Description'],
            collect($groups)
                ->map(fn (array $group, string $name): array => [
                    $name,
                    count($group['aliases']),
                    $group['description'],
                ])
                ->values()
                ->all(),
        );

        return self::SUCCESS;
    }

    /**
     * @return array<string, array{description: string, aliases: array<string, string>}>
     */
    private function aliasGroups(): array
    {
        $groups = config('alias-manager.groups', []);

        if (! is_array($groups)) {
            return [];
        }

        return collect($groups)
            ->filter(fn (mixed $group): bool => is_array($group))
            ->mapWithKeys(function (array $group, string $name): array {
                $aliases = $group['aliases'] ?? [];

                return [
                    $name => [
                        'description' => is_string($group['description'] ?? null) ? $group['description'] : '',
                        'aliases' => is_array($aliases) ? $aliases : [],
                    ],
                ];
            })
            ->all();
    }
}
