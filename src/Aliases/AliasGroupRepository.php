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
}
