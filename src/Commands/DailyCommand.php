<?php

declare(strict_types=1);

namespace Vardanm1993\LaravelAliasManager\Commands;

use Illuminate\Console\Command;
use Vardanm1993\LaravelAliasManager\Aliases\AliasGroupRepository;

final class DailyCommand extends Command
{
    protected $signature = 'alias-manager:daily {aliases?* : Optional daily alias names to inspect}';

    protected $description = 'Show daily favorites that can be rendered into the shell daily function.';

    public function handle(AliasGroupRepository $repository): int
    {
        $names = $this->aliasNames();
        $missing = $repository->missingDailyAliases($names);

        if ($missing !== []) {
            $this->components->error(sprintf('Unknown daily alias(es): %s', implode(', ', $missing)));

            return self::FAILURE;
        }

        $daily = $repository->daily($names);

        if ($daily === []) {
            $this->components->warn('No daily favorites configured. Use --daily on install or configure alias-manager.daily.');

            return self::SUCCESS;
        }

        $this->components->info('Daily Favorites');

        $this->table(
            ['Alias', 'Group', 'Command'],
            collect($daily)
                ->map(fn (array $data, string $alias): array => [$alias, $data['group'], $data['command']])
                ->values()
                ->all(),
        );

        return self::SUCCESS;
    }

    /**
     * @return array<string>
     */
    private function aliasNames(): array
    {
        $aliases = $this->argument('aliases');

        if (! is_array($aliases)) {
            return [];
        }

        return array_values(array_filter($aliases, is_string(...)));
    }
}
