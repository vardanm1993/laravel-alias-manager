<?php

declare(strict_types=1);

namespace Vardanm1993\LaravelAliasManager\Commands;

use Illuminate\Console\Command;

final class ShowCommand extends Command
{
    protected $signature = 'alias-manager:show {group : The alias group name}';

    protected $description = 'Show aliases for a specific Laravel Alias Manager group.';

    public function handle(): int
    {
        $groupName = (string) $this->argument('group');
        $group = $this->aliasGroup($groupName);

        if ($group === null) {
            $this->components->error(sprintf('Alias group [%s] was not found.', $groupName));

            return self::FAILURE;
        }

        $this->components->info(sprintf('Alias Group: %s', $groupName));
        $this->line($group['description']);
        $this->newLine();

        $this->table(
            ['Alias', 'Command'],
            collect($group['aliases'])
                ->map(fn (string $command, string $alias): array => [$alias, $command])
                ->values()
                ->all(),
        );

        return self::SUCCESS;
    }

    /**
     * @return array{description: string, aliases: array<string, string>}|null
     */
    private function aliasGroup(string $name): ?array
    {
        $group = config(sprintf('alias-manager.groups.%s', $name));

        if (! is_array($group)) {
            return null;
        }

        $aliases = $group['aliases'] ?? [];

        return [
            'description' => is_string($group['description'] ?? null) ? $group['description'] : '',
            'aliases' => is_array($aliases) ? $this->stringAliases($aliases) : [],
        ];
    }

    /**
     * @param  array<mixed>  $aliases
     * @return array<string, string>
     */
    private function stringAliases(array $aliases): array
    {
        $normalized = [];

        foreach ($aliases as $alias => $command) {
            if (! is_string($alias) || ! is_string($command)) {
                continue;
            }

            $normalized[$alias] = $command;
        }

        return $normalized;
    }
}
