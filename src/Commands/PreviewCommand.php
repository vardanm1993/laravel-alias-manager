<?php

declare(strict_types=1);

namespace Vardanm1993\LaravelAliasManager\Commands;

use Illuminate\Console\Command;
use Vardanm1993\LaravelAliasManager\Aliases\AliasGroupRepository;
use Vardanm1993\LaravelAliasManager\Shell\ShellAliasRenderer;

final class PreviewCommand extends Command
{
    protected $signature = 'alias-manager:preview
        {groups?* : Optional alias group names}
        {--preset=* : Optional preset name(s)}
        {--daily=* : Daily favorite alias names rendered into the daily shell function}';

    protected $description = 'Preview the managed shell alias block without writing to shell files.';

    public function handle(AliasGroupRepository $groups, ShellAliasRenderer $renderer): int
    {
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

        $this->line($renderer->render($groups->only($names), $groups->daily($dailyNames, $names)));

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
