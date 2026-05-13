<?php

declare(strict_types=1);

return [
    /*
    |--------------------------------------------------------------------------
    | Managed Shells
    |--------------------------------------------------------------------------
    |
    | These shells will be supported by the package installer. The first
    | implementation will focus on safe Bash and Zsh configuration updates.
    |
    */
    'shells' => [
        'bash',
        'zsh',
    ],

    /*
    |--------------------------------------------------------------------------
    | Backup Shell Files
    |--------------------------------------------------------------------------
    |
    | The package should create a backup before modifying any user shell file.
    |
    */
    'backup' => true,

    /*
    |--------------------------------------------------------------------------
    | Alias Groups
    |--------------------------------------------------------------------------
    |
    | These groups define the built-in alias catalog. Commands read this
    | catalog first; shell file installation will be added separately.
    |
    */
    'groups' => [
        'system' => [
            'description' => 'System and navigation shortcuts.',
            'aliases' => [
                'c' => 'clear',
                '..' => 'cd ..',
                '...' => 'cd ../..',
                'll' => 'ls -lah',
                'la' => 'ls -la',
                'md' => 'mkdir -p',
            ],
        ],
        'git' => [
            'description' => 'Git workflow shortcuts.',
            'aliases' => [
                'gs' => 'git status',
                'ga' => 'git add',
                'gaa' => 'git add .',
                'gb' => 'git branch',
                'gco' => 'git checkout',
                'gcb' => 'git checkout -b',
                'gc' => 'git commit',
                'gcm' => 'git commit -m',
                'gd' => 'git diff',
                'gds' => 'git diff --staged',
                'gl' => 'git log --oneline --graph --decorate',
                'gpl' => 'git pull',
                'gp' => 'git push',
                'gpsu' => 'git push --set-upstream origin HEAD',
                'gst' => 'git stash',
                'gstp' => 'git stash pop',
            ],
        ],
        'composer' => [
            'description' => 'Composer package manager shortcuts.',
            'aliases' => [
                'ci' => 'composer install',
                'cu' => 'composer update',
                'cr' => 'composer require',
                'crm' => 'composer remove',
                'cdump' => 'composer dump-autoload',
                'co' => 'composer outdated',
                'cs' => 'composer show',
                'ct' => 'composer test',
            ],
        ],
        'php' => [
            'description' => 'PHP runtime and dependency inspection shortcuts.',
            'aliases' => [
                'pv' => 'php -v',
                'pm' => 'php -m',
                'pi' => 'php -i',
                'psy' => 'php artisan tinker',
            ],
        ],
        'artisan' => [
            'description' => 'Laravel Artisan shortcuts.',
            'aliases' => [
                'pa' => 'php artisan',
                'pas' => 'php artisan serve',
                'pat' => 'php artisan test',
                'pati' => 'php artisan tinker',
                'pam' => 'php artisan migrate',
                'pamf' => 'php artisan migrate:fresh',
                'pamfs' => 'php artisan migrate:fresh --seed',
                'pads' => 'php artisan db:seed',
                'paq' => 'php artisan queue:work',
                'pasch' => 'php artisan schedule:work',
                'pac' => 'php artisan cache:clear',
                'pacc' => 'php artisan config:clear',
                'parc' => 'php artisan route:clear',
                'pavc' => 'php artisan view:clear',
                'pao' => 'php artisan optimize',
                'paoc' => 'php artisan optimize:clear',
                'parl' => 'php artisan route:list',
                'paml' => 'php artisan make:livewire',
                'pamc' => 'php artisan make:controller',
                'pamm' => 'php artisan make:model',
                'pammi' => 'php artisan make:migration',
            ],
        ],
        'sail' => [
            'description' => 'Laravel Sail shortcuts.',
            'aliases' => [
                'sail' => './vendor/bin/sail',
                'sau' => './vendor/bin/sail up',
                'saud' => './vendor/bin/sail up -d',
                'sd' => './vendor/bin/sail down',
                'sr' => './vendor/bin/sail restart',
                'sshell' => './vendor/bin/sail shell',
                'sroot' => './vendor/bin/sail root-shell',
                'sa' => './vendor/bin/sail artisan',
                'sat' => './vendor/bin/sail artisan test',
                'sam' => './vendor/bin/sail artisan migrate',
                'samf' => './vendor/bin/sail artisan migrate:fresh',
                'samfs' => './vendor/bin/sail artisan migrate:fresh --seed',
                'satk' => './vendor/bin/sail artisan tinker',
                'saoc' => './vendor/bin/sail artisan optimize:clear',
                'sarl' => './vendor/bin/sail artisan route:list',
                'sc' => './vendor/bin/sail composer',
                'sci' => './vendor/bin/sail composer install',
                'scu' => './vendor/bin/sail composer update',
                'scr' => './vendor/bin/sail composer require',
                'sn' => './vendor/bin/sail npm',
                'sni' => './vendor/bin/sail npm install',
                'snd' => './vendor/bin/sail npm run dev',
                'snb' => './vendor/bin/sail npm run build',
                'spnpm' => './vendor/bin/sail pnpm',
                'spnpi' => './vendor/bin/sail pnpm install',
                'spnpd' => './vendor/bin/sail pnpm dev',
                'sy' => './vendor/bin/sail yarn',
                'syd' => './vendor/bin/sail yarn dev',
                'sphp' => './vendor/bin/sail php',
                'spest' => './vendor/bin/sail pest',
                'spint' => './vendor/bin/sail pint',
                'sstan' => './vendor/bin/sail phpstan',
                'slogs' => './vendor/bin/sail logs',
            ],
        ],
        'npm' => [
            'description' => 'npm and Vite shortcuts.',
            'aliases' => [
                'n' => 'npm',
                'ni' => 'npm install',
                'nd' => 'npm run dev',
                'nb' => 'npm run build',
                'np' => 'npm run preview',
                'nt' => 'npm test',
                'nl' => 'npm run lint',
                'nf' => 'npm run format',
            ],
        ],
        'pnpm' => [
            'description' => 'pnpm frontend workflow shortcuts.',
            'aliases' => [
                'pn' => 'pnpm',
                'pni' => 'pnpm install',
                'pnd' => 'pnpm dev',
                'pnb' => 'pnpm build',
                'pnp' => 'pnpm preview',
                'pnt' => 'pnpm test',
                'pnl' => 'pnpm lint',
            ],
        ],
        'yarn' => [
            'description' => 'Yarn frontend workflow shortcuts.',
            'aliases' => [
                'y' => 'yarn',
                'yi' => 'yarn install',
                'yd' => 'yarn dev',
                'yb' => 'yarn build',
                'yp' => 'yarn preview',
                'yt' => 'yarn test',
                'yl' => 'yarn lint',
            ],
        ],
        'quality' => [
            'description' => 'Laravel and PHP quality tool shortcuts.',
            'aliases' => [
                'pest' => './vendor/bin/pest',
                'pestf' => './vendor/bin/pest --filter',
                'pint' => './vendor/bin/pint',
                'pintd' => './vendor/bin/pint --dirty',
                'stan' => './vendor/bin/phpstan analyse',
                'rector' => './vendor/bin/rector',
                'rectord' => './vendor/bin/rector --dry-run',
                'cq' => 'composer quality',
            ],
        ],
        'docker' => [
            'description' => 'Docker Compose shortcuts for local services.',
            'aliases' => [
                'dc' => 'docker compose',
                'dcu' => 'docker compose up',
                'dcud' => 'docker compose up -d',
                'dcd' => 'docker compose down',
                'dcr' => 'docker compose restart',
                'dcl' => 'docker compose logs',
                'dclf' => 'docker compose logs -f',
                'dps' => 'docker compose ps',
            ],
        ],
    ],
];
