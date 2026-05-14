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
        {--preset=* : Optional preset name(s)}
        {--daily=* : Daily favorite alias names rendered into the daily shell function}
        {--file= : Explicit shell profile file}
        {--no-backup : Do not create a backup before modifying the file}';

    protected $description = 'Install aliases into a shell profile using a managed block.';

    public function handle(
        AliasGroupRepository $groups,
        ShellProfileResolver $resolver,
        ShellProfileManager $profiles,
    ): int {
        $presetNames = $this->optionList('preset');
        $missingPresets = $groups->missingPresets($presetNames);

        if ($missingPresets !== []) {
            $this->components->error(sprintf('Unknown preset(s): %s', implode(', ', $missingPresets)));

            return self::FAILURE;
        }

        $names = $groups->groupNames($this->groupNames(), $presetNames);
        $missing = $groups->missing($names);

        if ($missing !== []) {
            $this->components->error(sprintf('Unknown alias group(s): %s', implode(', ', $missing)));

            return self::FAILURE;
        }

        $dailyNames = $this->optionList('daily');
        $missingDailyAliases = $groups->missingDailyAliases($dailyNames, $names);

        if ($missingDailyAliases !== []) {
            $this->components->error(sprintf('Unknown daily alias(es): %s', implode(', ', $missingDailyAliases)));

            return self::FAILURE;
        }

        $file = $resolver->resolve($this->optionString('file'));

        if ($file === null) {
            $this->components->error('Unable to detect a supported shell profile. Use --file to provide one.');

            return self::FAILURE;
        }

        $profiles->install($file, $groups->only($names), ! $this->option('no-backup'), $groups->daily($dailyNames, $names));

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

    /**
     * @return array<string>
     */
    private function optionList(string $name): array
    {
        $value = $this->option($name);

        if (! is_array($value)) {
            return [];
        }

        return array_values(array_filter($value, is_string(...)));
    }
}
