<?php

declare(strict_types=1);

namespace Vardanm1993\LaravelAliasManager\Shell;

final class ShellAliasRenderer
{
    public const BEGIN_MARKER = '# >>> laravel-alias-manager >>>';

    public const END_MARKER = '# <<< laravel-alias-manager <<<';

    /**
     * @param  array<string, array{description: string, aliases: array<string, string>}>  $groups
     * @param  array<string, array{group: string, command: string}>  $daily
     */
    public function render(array $groups, array $daily = []): string
    {
        $lines = [
            self::BEGIN_MARKER,
            '# This block is managed by Laravel Alias Manager.',
            '# Shortcuts run only inside a Laravel project.',
            '',
            '__lam_find_laravel_root() {',
            '    local dir="$PWD"',
            '',
            '    while [ "$dir" != "/" ]; do',
            '        if [ -f "$dir/artisan" ] && [ -f "$dir/composer.json" ] && [ -f "$dir/bootstrap/app.php" ]; then',
            '            printf \'%s\n\' "$dir"',
            '            return 0',
            '        fi',
            '',
            '        dir="$(dirname "$dir")"',
            '    done',
            '',
            '    return 1',
            '}',
            '',
            '__lam_require_laravel_root() {',
            '    local root',
            '    root="$(__lam_find_laravel_root)"',
            '',
            '    if [ -z "$root" ]; then',
            '        printf \'%s\n\' "Laravel Alias Manager: not inside a Laravel project." >&2',
            '        return 1',
            '    fi',
            '',
            '    printf \'%s\n\' "$root"',
            '}',
            '',
            'lamroot() {',
            '    __lam_require_laravel_root',
            '}',
            '',
            'lamcd() {',
            '    local root',
            '    root="$(__lam_require_laravel_root)" || return 1',
            '    cd "$root" || return 1',
            '}',
            '',
            '__lam_run_cmd() {',
            '    local command_text="$1"',
            '    local root',
            '    shift',
            '',
            '    root="$(__lam_require_laravel_root)" || return 1',
            '    if [ "$#" -eq 0 ]; then',
            '        (cd "$root" && eval "$command_text")',
            '    else',
            '        (cd "$root" && eval "$command_text \"\$@\"")',
            '    fi',
            '}',
        ];

        foreach ($groups as $name => $group) {
            if ($group['aliases'] === []) {
                continue;
            }

            $lines[] = '';
            $lines[] = sprintf('# %s: %s', $name, $group['description']);

            foreach ($group['aliases'] as $alias => $command) {
                $lines[] = sprintf('%s() {', $alias);
                $lines[] = sprintf("    __lam_run_cmd '%s' \"\$@\"", $this->escapeSingleQuotedCommand($command));
                $lines[] = '}';
            }
        }

        $lines[] = '';
        $lines[] = '# daily: User-selected daily favorites.';
        $lines[] = 'lamdaily() {';

        if ($daily === []) {
            $lines[] = '    printf \'%s\n\' "Laravel Alias Manager: no daily favorites configured."';
        } else {
            foreach (array_keys($daily) as $alias) {
                $lines[] = sprintf('    %s || return $?', $alias);
            }
        }

        $lines[] = '}';
        $lines[] = '';
        $lines[] = 'daily() {';
        $lines[] = '    lamdaily "$@"';
        $lines[] = '}';
        $lines[] = '';
        $lines[] = self::END_MARKER;

        return implode(PHP_EOL, $lines).PHP_EOL;
    }

    private function escapeSingleQuotedCommand(string $command): string
    {
        return str_replace("'", "'\\''", $command);
    }
}
