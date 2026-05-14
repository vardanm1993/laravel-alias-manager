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
            '__lam_run() {',
            '    local root',
            '    root="$(__lam_require_laravel_root)" || return 1',
            '    (cd "$root" && "$@")',
            '}',
        ];

        foreach ($groups as $name => $group) {
            if ($group['aliases'] === []) {
                continue;
            }

            $lines[] = '';
            $lines[] = sprintf('# %s: %s', $name, $group['description']);

            foreach ($group['aliases'] as $alias => $command) {
                $lines[] = sprintf("alias %s='%s'", $alias, $this->escapeSingleQuotedCommand('__lam_run '.$command));
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
