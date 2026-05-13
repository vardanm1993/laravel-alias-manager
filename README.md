# Laravel Alias Manager

A professional alias and shortcut manager for Laravel, PHP, Sail, Composer, Git, npm, pnpm, Yarn, Vite, Pest, Pint, Rector, PHPStan, and Docker workflows.

> Current release: v0.1.0.

## Purpose

Laravel Alias Manager helps developers keep terminal shortcuts organized, readable, safe, and project-aware.

The package will provide installable alias groups for common Laravel and PHP workflows, including Artisan, Laravel Sail, Composer, Git, npm, pnpm, Yarn, Vite, Pest, Pint, Rector, PHPStan, Larastan, and Docker.

## Features

- Laravel package service provider
- Publishable configuration
- Console commands for about, list, show, preview, install, uninstall, and doctor
- Bash and Zsh support
- Safe shell file detection
- Backup before modifying shell files
- Reversible managed alias blocks
- Built-in alias packs for common PHP and Laravel workflows
- Pest test coverage
- GitHub Actions quality pipeline

## Installation

```bash
composer require vardanm1993/laravel-alias-manager
```

Publish the package config:

```bash
php artisan vendor:publish --tag=alias-manager-config
```

## Usage

Display package information:

```bash
php artisan alias-manager:about
```

List available alias groups:

```bash
php artisan alias-manager:list
```

Show aliases for one group:

```bash
php artisan alias-manager:show git
```

Preview the shell block without writing to any file:

```bash
php artisan alias-manager:preview git composer
```

Install aliases into the detected shell profile:

```bash
php artisan alias-manager:install git composer
```

Install aliases into an explicit shell file:

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

Current built-in groups:

- `system`
- `git`
- `composer`
- `php`
- `artisan`
- `sail`
- `npm`
- `pnpm`
- `yarn`
- `quality`
- `docker`

## Shell Safety

Aliases are rendered inside a managed shell block.

The package uses clear begin and end markers so install and uninstall commands update only the package-owned block.

```text
# >>> laravel-alias-manager >>>
# This block is managed by Laravel Alias Manager.
...
# <<< laravel-alias-manager <<<
```

Before modifying an existing shell file, the package creates a timestamped `.bak` backup by default.

## Development Status

The current development target is the next release after v0.1.0.

Run the full local quality suite:

```bash
composer quality
```

## License

Laravel Alias Manager is open-sourced software licensed under the [MIT license](LICENSE).
