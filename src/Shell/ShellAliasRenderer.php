<?php

declare(strict_types=1);

namespace Vardanm1993\LaravelAliasManager\Shell;

final class ShellAliasRenderer
{
    public const BEGIN_MARKER = '# >>> laravel-alias-manager >>>';

    public const END_MARKER = '# <<< laravel-alias-manager <<<';

    /**
     * @param  array<string, array{description: string, aliases: array<string, string>}>  $groups
     */
    public function render(array $groups): string
    {
        $lines = [
            self::BEGIN_MARKER,
            '# This block is managed by Laravel Alias Manager.',
        ];

        foreach ($groups as $name => $group) {
            if ($group['aliases'] === []) {
                continue;
            }

            $lines[] = '';
            $lines[] = sprintf('# %s: %s', $name, $group['description']);

            foreach ($group['aliases'] as $alias => $command) {
                $lines[] = sprintf("alias %s='%s'", $alias, $this->escapeSingleQuotedCommand($command));
            }
        }

        $lines[] = '';
        $lines[] = self::END_MARKER;

        return implode(PHP_EOL, $lines).PHP_EOL;
    }

    private function escapeSingleQuotedCommand(string $command): string
    {
        return str_replace("'", "'\\''", $command);
    }
}
