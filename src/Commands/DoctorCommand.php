<?php

declare(strict_types=1);

namespace Vardanm1993\LaravelAliasManager\Commands;

use Illuminate\Console\Command;
use Vardanm1993\LaravelAliasManager\Aliases\AliasGroupRepository;
use Vardanm1993\LaravelAliasManager\Shell\ShellProfileResolver;

final class DoctorCommand extends Command
{
    protected $signature = 'alias-manager:doctor {--file= : Explicit shell profile file}';

    protected $description = 'Check Laravel Alias Manager configuration and shell profile readiness.';

    public function handle(AliasGroupRepository $groups, ShellProfileResolver $resolver): int
    {
        $profile = $resolver->resolve($this->optionString('file'));
        $groupCount = count($groups->all());

        $this->components->info('Laravel Alias Manager Doctor');

        $this->components->twoColumnDetail('Alias groups', (string) $groupCount);
        $this->components->twoColumnDetail('Backup enabled', config('alias-manager.backup', true) ? 'yes' : 'no');
        $this->components->twoColumnDetail('Shell profile', $profile ?? 'not detected');

        if ($groupCount === 0) {
            $this->components->error('No alias groups are configured.');

            return self::FAILURE;
        }

        if ($profile === null) {
            $this->components->warn('Shell profile was not detected. Install can still use --file.');
        }

        return self::SUCCESS;
    }

    private function optionString(string $name): ?string
    {
        $value = $this->option($name);

        return is_string($value) && $value !== '' ? $value : null;
    }
}
