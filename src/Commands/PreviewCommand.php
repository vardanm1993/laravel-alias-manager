<?php

declare(strict_types=1);

namespace Vardanm1993\LaravelAliasManager\Commands;

use Illuminate\Console\Command;
use Vardanm1993\LaravelAliasManager\Aliases\AliasGroupRepository;
use Vardanm1993\LaravelAliasManager\Shell\ShellAliasRenderer;

final class PreviewCommand extends Command
{
    protected $signature = 'alias-manager:preview {groups?* : Optional alias group names}';

    protected $description = 'Preview the managed shell alias block without writing to shell files.';

    public function handle(AliasGroupRepository $groups, ShellAliasRenderer $renderer): int
    {
        $names = $this->groupNames();
        $missing = $groups->missing($names);

        if ($missing !== []) {
            $this->components->error(sprintf('Unknown alias group(s): %s', implode(', ', $missing)));

            return self::FAILURE;
        }

        $this->line($renderer->render($groups->only($names)));

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
}
