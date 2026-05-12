<?php

declare(strict_types=1);

namespace Vardanm1993\LaravelAliasManager\Commands;

use Illuminate\Console\Command;
use Vardanm1993\LaravelAliasManager\Aliases\AliasGroupRepository;

final class ListCommand extends Command
{
    protected $signature = 'alias-manager:list';

    protected $description = 'List available Laravel Alias Manager alias groups.';

    public function handle(AliasGroupRepository $repository): int
    {
        $groups = $repository->all();

        $this->components->info('Available Alias Groups');

        $this->table(
            ['Group', 'Aliases', 'Description'],
            collect($groups)
                ->map(fn (array $group, string $name): array => [
                    $name,
                    count($group['aliases']),
                    $group['description'],
                ])
                ->values()
                ->all(),
        );

        return self::SUCCESS;
    }
}
