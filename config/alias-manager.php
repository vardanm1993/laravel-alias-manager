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
];
