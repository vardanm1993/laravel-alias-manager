<?php

declare(strict_types=1);

namespace Vardanm1993\LaravelAliasManager\Commands;

use Illuminate\Console\Command;

final class AboutCommand extends Command
{
    protected $signature = 'alias-manager:about';

    protected $description = 'Display information about Laravel Alias Manager.';

    public function handle(): int
    {
        $this->components->info('Laravel Alias Manager');

        $this->newLine();

        $this->components->twoColumnDetail('Package', 'vardanm1993/laravel-alias-manager');
        $this->components->twoColumnDetail('Version', 'dev-main');
        $this->components->twoColumnDetail('Purpose', 'Manage Laravel and PHP workflow aliases safely.');
        $this->components->twoColumnDetail('Repository', 'https://github.com/vardanm1993/laravel-alias-manager');

        return self::SUCCESS;
    }
}
