<?php

declare(strict_types=1);

namespace Vardanm1993\LaravelAliasManager\Commands;

use Illuminate\Console\Command;
use Vardanm1993\LaravelAliasManager\Shell\ShellProfileManager;
use Vardanm1993\LaravelAliasManager\Shell\ShellProfileResolver;

final class UninstallCommand extends Command
{
    protected $signature = 'alias-manager:uninstall
        {--file= : Explicit shell profile file}
        {--no-backup : Do not create a backup before modifying the file}';

    protected $description = 'Remove the managed Laravel Alias Manager block from a shell profile.';

    public function handle(ShellProfileResolver $resolver, ShellProfileManager $profiles): int
    {
        $file = $resolver->resolve($this->optionString('file'));

        if ($file === null) {
            $this->components->error('Unable to detect a supported shell profile. Use --file to provide one.');

            return self::FAILURE;
        }

        if (! $profiles->uninstall($file, ! $this->option('no-backup'))) {
            $this->components->warn(sprintf('No managed aliases were found in %s.', $file));

            return self::SUCCESS;
        }

        $this->components->info(sprintf('Aliases removed from %s.', $file));

        return self::SUCCESS;
    }

    private function optionString(string $name): ?string
    {
        $value = $this->option($name);

        return is_string($value) && $value !== '' ? $value : null;
    }
}
