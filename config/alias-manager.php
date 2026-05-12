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
            ],
        ],
        'git' => [
            'description' => 'Git workflow shortcuts.',
            'aliases' => [
                'gs' => 'git status',
                'ga' => 'git add',
                'gc' => 'git commit',
                'gp' => 'git push',
            ],
        ],
        'composer' => [
            'description' => 'Composer package manager shortcuts.',
            'aliases' => [
                'cu' => 'composer update',
                'ci' => 'composer install',
                'cr' => 'composer require',
                'ct' => 'composer test',
            ],
        ],
        'artisan' => [
            'description' => 'Laravel Artisan shortcuts.',
            'aliases' => [
                'pa' => 'php artisan',
                'pam' => 'php artisan migrate',
                'pat' => 'php artisan test',
                'parl' => 'php artisan route:list',
            ],
        ],
        'sail' => [
            'description' => 'Laravel Sail shortcuts.',
            'aliases' => [
                'sail' => './vendor/bin/sail',
                'sa' => './vendor/bin/sail artisan',
                'sc' => './vendor/bin/sail composer',
                'sn' => './vendor/bin/sail npm',
            ],
        ],
        'npm' => [
            'description' => 'npm and Vite shortcuts.',
            'aliases' => [
                'nd' => 'npm run dev',
                'nb' => 'npm run build',
                'ni' => 'npm install',
                'nt' => 'npm test',
            ],
        ],
    ],
];
