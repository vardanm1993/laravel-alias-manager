# Laravel Alias Manager

A professional alias and shortcut manager for Laravel, PHP, Sail, Composer, Git, npm, Vite, Pest, Pint, Rector, and PHPStan workflows.

> This package is currently in early development.

## Purpose

Laravel Alias Manager helps developers keep terminal shortcuts organized, readable, safe, and project-aware.

The package will provide installable alias groups for common Laravel and PHP workflows, including Artisan, Laravel Sail, Composer, Git, npm, Vite, Pest, Pint, Rector, PHPStan, and Larastan.

## Planned Features

- Laravel package service provider
- Publishable configuration
- Console commands for about, install, uninstall, doctor, and help
- Bash and Zsh support
- Safe shell file detection
- Backup before modifying shell files
- Reversible managed alias blocks
- Built-in alias packs for common PHP and Laravel workflows
- Custom alias support
- Pest test coverage
- GitHub Actions quality pipeline

## Installation

Installation instructions will be added after the first package version is implemented.

Planned package name:

```bash
composer require vardanm1993/laravel-alias-manager
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

Current built-in groups:

- `system`
- `git`
- `composer`
- `artisan`
- `sail`
- `npm`

## Development Status

This repository is being built step by step as a professional Laravel package.

## License

Laravel Alias Manager is open-sourced software licensed under the [MIT license](LICENSE).
