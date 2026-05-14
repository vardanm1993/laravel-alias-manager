<?php

declare(strict_types=1);

namespace Vardanm1993\LaravelAliasManager\Aliases;

final class AliasGroupRepository
{
    /**
     * @return array<string, array{description: string, aliases: array<string, string>}>
     */
    public function all(): array
    {
        $groups = config('alias-manager.groups', []);

        if (! is_array($groups)) {
            return [];
        }

        $normalized = [];

        foreach ($groups as $name => $group) {
            if (! is_string($name) || ! is_array($group)) {
                continue;
            }

            $normalized[$name] = [
                'description' => is_string($group['description'] ?? null) ? $group['description'] : '',
                'aliases' => $this->stringAliases($group['aliases'] ?? []),
            ];
        }

        return $normalized;
    }

    /**
     * @return array{description: string, aliases: array<string, string>}|null
     */
    public function find(string $name): ?array
    {
        return $this->all()[$name] ?? null;
    }

    /**
     * @return array<string, array{description: string, groups: array<string>}>
     */
    public function presets(): array
    {
        $presets = config('alias-manager.presets', []);

        if (! is_array($presets)) {
            return [];
        }

        $normalized = [];

        foreach ($presets as $name => $preset) {
            if (! is_string($name) || ! is_array($preset)) {
                continue;
            }

            $normalized[$name] = [
                'description' => is_string($preset['description'] ?? null) ? $preset['description'] : '',
                'groups' => $this->stringList($preset['groups'] ?? []),
            ];
        }

        return $normalized;
    }

    /**
     * @return array{description: string, groups: array<string>}|null
     */
    public function preset(string $name): ?array
    {
        return $this->presets()[$name] ?? null;
    }

    /**
     * @param  array<string>  $names
     * @return array<string>
     */
    public function missing(array $names): array
    {
        $groups = $this->all();

        return array_values(array_filter(
            $names,
            static fn (string $name): bool => ! array_key_exists($name, $groups),
        ));
    }

    /**
     * @param  array<string>  $names
     * @return array<string>
     */
    public function missingPresets(array $names): array
    {
        $presets = $this->presets();

        return array_values(array_filter(
            $names,
            static fn (string $name): bool => ! array_key_exists($name, $presets),
        ));
    }

    /**
     * @param  array<string>  $groups
     * @param  array<string>  $presets
     * @return array<string>
     */
    public function groupNames(array $groups = [], array $presets = []): array
    {
        $selected = $groups;

        foreach ($presets as $preset) {
            $selected = array_merge($selected, $this->preset($preset)['groups'] ?? []);
        }

        return array_values(array_unique(array_filter($selected, is_string(...))));
    }

    /**
     * @param  array<string>  $names
     * @return array<string, array{description: string, aliases: array<string, string>}>
     */
    public function only(array $names): array
    {
        if ($names === []) {
            return $this->all();
        }

        $groups = $this->all();
        $selected = [];

        foreach ($names as $name) {
            if (array_key_exists($name, $groups)) {
                $selected[$name] = $groups[$name];
            }
        }

        return $selected;
    }

    /**
     * @param  array<string>  $groups
     * @return array<string, array{group: string, command: string}>
     */
    public function aliases(array $groups = []): array
    {
        $aliases = [];

        foreach ($this->only($groups) as $groupName => $group) {
            foreach ($group['aliases'] as $alias => $command) {
                $aliases[$alias] = [
                    'group' => $groupName,
                    'command' => $command,
                ];
            }
        }

        return $aliases;
    }

    /**
     * @param  array<string>  $dailyAliases
     * @param  array<string>  $groups
     * @return array<string, array{group: string, command: string}>
     */
    public function daily(array $dailyAliases = [], array $groups = []): array
    {
        $dailyAliases = $dailyAliases === [] ? $this->configuredDailyAliases() : $dailyAliases;
        $aliases = $this->aliases($groups);
        $daily = [];

        foreach ($dailyAliases as $alias) {
            if (array_key_exists($alias, $aliases)) {
                $daily[$alias] = $aliases[$alias];
            }
        }

        return $daily;
    }

    /**
     * @param  array<string>  $dailyAliases
     * @param  array<string>  $groups
     * @return array<string>
     */
    public function missingDailyAliases(array $dailyAliases = [], array $groups = []): array
    {
        $dailyAliases = $dailyAliases === [] ? $this->configuredDailyAliases() : $dailyAliases;
        $aliases = $this->aliases($groups);

        return array_values(array_filter(
            $dailyAliases,
            static fn (string $alias): bool => ! array_key_exists($alias, $aliases),
        ));
    }

    /**
     * @return array<string>
     */
    public function configuredDailyAliases(): array
    {
        return $this->stringList(config('alias-manager.daily', []));
    }

    /**
     * @return array<int, array{alias: string, group: string, command: string}>
     */
    public function search(string $query): array
    {
        $query = trim(strtolower($query));

        if ($query === '') {
            return [];
        }

        $matches = [];

        foreach ($this->aliases() as $alias => $data) {
            $haystack = strtolower(sprintf('%s %s %s', $alias, $data['group'], $data['command']));

            if (! str_contains($haystack, $query)) {
                continue;
            }

            $matches[] = [
                'alias' => $alias,
                'group' => $data['group'],
                'command' => $data['command'],
            ];
        }

        return $matches;
    }

    /**
     * @return array<string, string>
     */
    private function stringAliases(mixed $aliases): array
    {
        if (! is_array($aliases)) {
            return [];
        }

        $normalized = [];

        foreach ($aliases as $alias => $command) {
            if (! is_string($alias) || ! is_string($command)) {
                continue;
            }

            $normalized[$alias] = $command;
        }

        return $normalized;
    }

    /**
     * @return array<string>
     */
    private function stringList(mixed $values): array
    {
        if (! is_array($values)) {
            return [];
        }

        return array_values(array_filter($values, is_string(...)));
    }
}
