<?php

declare(strict_types=1);

namespace Vardanm1993\LaravelAliasManager\Commands;

use Illuminate\Console\Command;
use Vardanm1993\LaravelAliasManager\Aliases\AliasGroupRepository;

final class ShowCommand extends Command
{
    protected $signature = 'alias-manager:show {group : The alias group name}';

    protected $description = 'Show aliases for a specific Laravel Alias Manager group.';

    public function handle(AliasGroupRepository $repository): int
    {
        $groupName = (string) $this->argument('group');
        $group = $repository->find($groupName);

        if ($group === null) {
            $this->components->error(sprintf('Alias group [%s] was not found.', $groupName));

            return self::FAILURE;
        }

        $this->components->info(sprintf('Alias Group: %s', $groupName));
        $this->line($group['description']);
        $this->newLine();

        $this->table(
            ['Alias', 'Command'],
            collect($group['aliases'])
                ->map(fn (string $command, string $alias): array => [$alias, $command])
                ->values()
                ->all(),
        );

        return self::SUCCESS;
    }
}
