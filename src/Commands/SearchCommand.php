<?php

declare(strict_types=1);

namespace Vardanm1993\LaravelAliasManager\Commands;

use Illuminate\Console\Command;
use Vardanm1993\LaravelAliasManager\Aliases\AliasGroupRepository;

final class SearchCommand extends Command
{
    protected $signature = 'alias-manager:search {query : Alias, group, or command text to search for}';

    protected $description = 'Search Laravel Alias Manager aliases by name, group, or command.';

    public function handle(AliasGroupRepository $repository): int
    {
        $query = (string) $this->argument('query');
        $matches = $repository->search($query);

        if ($matches === []) {
            $this->components->warn(sprintf('No aliases matched [%s].', $query));

            return self::SUCCESS;
        }

        $this->components->info(sprintf('Alias Search: %s', $query));

        $this->table(
            ['Alias', 'Group', 'Command'],
            collect($matches)
                ->map(fn (array $match): array => [$match['alias'], $match['group'], $match['command']])
                ->values()
                ->all(),
        );

        return self::SUCCESS;
    }
}
