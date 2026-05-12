<?php

declare(strict_types=1);

namespace Vardanm1993\LaravelAliasManager\Commands;

use Illuminate\Console\Command;
use Vardanm1993\LaravelAliasManager\Aliases\AliasGroupRepository;
use Vardanm1993\LaravelAliasManager\Shell\ShellProfileManager;
use Vardanm1993\LaravelAliasManager\Shell\ShellProfileResolver;

final class InstallCommand extends Command
{
    protected $signature = 'alias-manager:install
        {groups?* : Optional alias group names}
        {--file= : Explicit shell profile file}
        {--no-backup : Do not create a backup before modifying the file}';

    protected $description = 'Install aliases into a shell profile using a managed block.';

    public function handle(
        AliasGroupRepository $groups,
        ShellProfileResolver $resolver,
        ShellProfileManager $profiles,
    ): int {
        $names = $this->groupNames();
        $missing = $groups->missing($names);

        if ($missing !== []) {
            $this->components->error(sprintf('Unknown alias group(s): %s', implode(', ', $missing)));

            return self::FAILURE;
        }

        $file = $resolver->resolve($this->optionString('file'));

        if ($file === null) {
            $this->components->error('Unable to detect a supported shell profile. Use --file to provide one.');

            return self::FAILURE;
        }

        $profiles->install($file, $groups->only($names), ! $this->option('no-backup'));

        $this->components->info(sprintf('Aliases installed into %s.', $file));

        return self::SUCCESS;
    }

    /**
     * @return array<string>
     */
    private function groupNames(): array
    {
        $groups = $this->argument('groups');

        if (! is_array($groups)) {
            return [];
        }

        return array_values(array_filter($groups, is_string(...)));
    }

    private function optionString(string $name): ?string
    {
        $value = $this->option($name);

        return is_string($value) && $value !== '' ? $value : null;
    }
}
