<?php

declare(strict_types=1);

namespace Vardanm1993\LaravelAliasManager\Commands;

use Illuminate\Console\Command;
use Vardanm1993\LaravelAliasManager\Aliases\AliasGroupRepository;

final class PresetsCommand extends Command
{
    protected $signature = 'alias-manager:presets {preset? : Optional preset name to inspect}';

    protected $description = 'List Laravel Alias Manager install presets.';

    public function handle(AliasGroupRepository $repository): int
    {
        $presetName = $this->argument('preset');

        if (is_string($presetName) && $presetName !== '') {
            return $this->showPreset($repository, $presetName);
        }

        $this->components->info('Available Alias Presets');

        $this->table(
            ['Preset', 'Groups', 'Description'],
            collect($repository->presets())
                ->map(fn (array $preset, string $name): array => [
                    $name,
                    implode(', ', $preset['groups']),
                    $preset['description'],
                ])
                ->values()
                ->all(),
        );

        return self::SUCCESS;
    }

    private function showPreset(AliasGroupRepository $repository, string $name): int
    {
        $preset = $repository->preset($name);

        if ($preset === null) {
            $this->components->error(sprintf('Alias preset [%s] was not found.', $name));

            return self::FAILURE;
        }

        $this->components->info(sprintf('Alias Preset: %s', $name));
        $this->line($preset['description']);
        $this->newLine();

        $this->table(
            ['Group', 'Aliases', 'Description'],
            collect($repository->only($preset['groups']))
                ->map(fn (array $group, string $groupName): array => [
                    $groupName,
                    count($group['aliases']),
                    $group['description'],
                ])
                ->values()
                ->all(),
        );

        return self::SUCCESS;
    }
}
