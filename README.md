# Laravel Alias Manager

[![Latest Version on Packagist](https://img.shields.io/packagist/v/vardanm1993/laravel-alias-manager.svg?style=flat-square)](https://packagist.org/packages/vardanm1993/laravel-alias-manager)
[![Total Downloads](https://img.shields.io/packagist/dt/vardanm1993/laravel-alias-manager.svg?style=flat-square)](https://packagist.org/packages/vardanm1993/laravel-alias-manager)
[![Composer Quality](https://img.shields.io/github/actions/workflow/status/vardanm1993/laravel-alias-manager/ci.yml?branch=main&label=quality&style=flat-square)](https://github.com/vardanm1993/laravel-alias-manager/actions/workflows/ci.yml)
[![License](https://img.shields.io/packagist/l/vardanm1993/laravel-alias-manager.svg?style=flat-square)](LICENSE)
[![PHP Version](https://img.shields.io/packagist/dependency-v/vardanm1993/laravel-alias-manager/php?style=flat-square)](composer.json)

A professional, project-aware alias and shortcut manager for Laravel, PHP, Sail, Composer, Git, npm, pnpm, Yarn, Vite, Pest, Pint, Rector, PHPStan, and Docker workflows.

Laravel Alias Manager keeps daily terminal shortcuts organized, readable, safe, and project-aware. It ships curated full-stack Laravel alias groups, renders them into guarded managed shell blocks, and can install or remove those blocks from Bash and Zsh profiles without touching the rest of the file.

## Preview

<p align="center">
  <img src="art/preview-list.svg" alt="Laravel Alias Manager alias groups terminal preview" width="900">
</p>

<p align="center">
  <img src="art/preview-install.svg" alt="Laravel Alias Manager managed alias block terminal preview" width="900">
</p>

```bash
php artisan alias-manager:install git artisan sail quality
```

```text
# >>> laravel-alias-manager >>>
# This block is managed by Laravel Alias Manager.
# Shortcuts run only inside a Laravel project.

# git: Git workflow shortcuts.
alias gs='__lam_run git status'
alias gco='__lam_run git checkout'
alias gpsu='__lam_run git push --set-upstream origin HEAD'

# sail: Laravel Sail shortcuts.
alias saud='__lam_run ./vendor/bin/sail up -d'
alias saildev='__lam_run ./vendor/bin/sail npm run dev'
alias sailfreshseed='__lam_run ./vendor/bin/sail artisan migrate:fresh --seed'

# <<< laravel-alias-manager <<<
```

## Features

- Curated, easy-to-remember aliases for full-stack Laravel, PHP, frontend, Sail, quality, and Docker workflows
- Project-aware shell guard that detects a Laravel root before any shortcut runs
- Shortcuts run from the Laravel project root, even when called from nested directories
- Laravel package auto-discovery
- Publishable configuration
- Console commands for listing, showing, previewing, installing, uninstalling, and diagnosing aliases
- Safe Bash and Zsh profile detection
- Timestamped shell-file backups before writes
- Reversible managed shell blocks with stable begin and end markers
- Pest, Pint, PHPStan, Rector, and GitHub Actions quality coverage

## Installation

Install the package with Composer:

```bash
composer require vardanm1993/laravel-alias-manager
```

Publish the configuration when you want to customize groups or aliases:

```bash
php artisan vendor:publish --tag=alias-manager-config
```

## Quick Start

Inspect the available groups:

```bash
php artisan alias-manager:list
```

Preview aliases before writing anything:

```bash
php artisan alias-manager:preview git artisan sail
```

Install selected aliases into the detected shell profile:

```bash
php artisan alias-manager:install git artisan sail npm quality
```

Install into a specific shell file:

```bash
php artisan alias-manager:install git composer --file=/path/to/.zshrc
```

Remove the managed block:

```bash
php artisan alias-manager:uninstall
```

Check package readiness:

```bash
php artisan alias-manager:doctor
```

## Alias Groups

| Group | Focus |
| --- | --- |
| `system` | Laravel project-root terminal helpers |
| `git` | Status, branches, diffs, commits, pulls, pushes, and stashes |
| `composer` | Install, update, require, remove, autoload, and package inspection |
| `php` | PHP runtime inspection and Laravel Tinker |
| `artisan` | Serve, test, migrate, seed, queue, schedule, cache, routes, storage, logs, and make commands |
| `sail` | Sail up/down, shell, Artisan, Composer, npm, pnpm, Yarn, PHP, Pest, Pint, PHPStan, and logs |
| `npm` | npm install, dev, build, preview, test, lint, format, audit, and outdated |
| `pnpm` | pnpm install, dev, build, preview, test, lint, format, add, and remove |
| `yarn` | Yarn install, dev, build, preview, test, lint, format, add, and remove |
| `quality` | Pest, Pint, PHPStan, Rector, and Composer quality with readable `q*` aliases |
| `docker` | Docker Compose up, down, restart, logs, ps, build, exec, PHP, and Artisan |

Show the exact aliases in any group:

```bash
php artisan alias-manager:show sail
```

## Sail Examples

```bash
saud      # ./vendor/bin/sail up -d
sd        # ./vendor/bin/sail down
sshell    # ./vendor/bin/sail shell
sa        # ./vendor/bin/sail artisan
samfs     # ./vendor/bin/sail artisan migrate:fresh --seed
snd       # ./vendor/bin/sail npm run dev
spnpd     # ./vendor/bin/sail pnpm dev
spest     # ./vendor/bin/sail pest
spint     # ./vendor/bin/sail pint
```

## Readable Examples

```bash
lserve          # php artisan serve
lfreshseed      # php artisan migrate:fresh --seed
lroutes         # php artisan route:list
llog            # tail -f storage/logs/laravel.log
sailupd         # ./vendor/bin/sail up -d
saildev         # ./vendor/bin/sail npm run dev
ndev            # npm run dev
qfix            # ./vendor/bin/pint
quality         # composer quality
```

## Shell Safety

Aliases are rendered inside a managed shell block:

```text
# >>> laravel-alias-manager >>>
# This block is managed by Laravel Alias Manager.
# Shortcuts run only inside a Laravel project.
...
# <<< laravel-alias-manager <<<
```

The managed block includes a small shell guard. Before a shortcut runs, it searches upward from the current directory for a Laravel root containing `artisan`, `composer.json`, and `bootstrap/app.php`. If no Laravel project is found, the shortcut stops with:

```text
Laravel Alias Manager: not inside a Laravel project.
```

When a Laravel project is found, the shortcut runs from that project root. That means `lroutes`, `saildev`, or `qfix` work from nested directories like `app/Http/Controllers`, but they do not run from unrelated folders.

The block also provides two helpers:

```bash
lamroot   # print the detected Laravel project root
lamcd     # cd to the detected Laravel project root
```

Install and uninstall commands only replace or remove the package-owned block. Existing aliases, exports, functions, prompts, and custom shell configuration outside that block are left untouched.

Before modifying an existing shell file, the package creates a timestamped `.bak` backup by default.

## Configuration

After publishing the config, edit `config/alias-manager.php`:

```php
'groups' => [
    'project' => [
        'description' => 'Project-specific shortcuts.',
        'aliases' => [
            'pa' => 'php artisan',
            'test' => 'php artisan test',
        ],
    ],
],
```

Then preview or install your custom group:

```bash
php artisan alias-manager:preview project
php artisan alias-manager:install project
```

Custom aliases are guarded the same way as the built-in catalog, so they only run inside a detected Laravel project.

## Development

Run the full local quality suite:

```bash
composer quality
```

Individual checks are also available:

```bash
composer lint
composer analyse
composer refactor:dry
composer test
```

## License

Laravel Alias Manager is open-sourced software licensed under the [MIT license](LICENSE).
