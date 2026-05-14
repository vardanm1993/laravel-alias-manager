# Changelog

All notable changes to `laravel-alias-manager` will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.1.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

### Added

- Added DAM-style alias names, including presets for core, fullstack, Sail, frontend, ops, and pro workflows.
- Added alias search, preset listing, and daily favorites commands.
- Added daily favorites rendering into the managed shell block.
- Added GitHub CLI, security, and workflow alias groups.

### Changed

- Render installed shortcuts as shell functions so compound commands and arguments work more reliably.

## [0.3.0] - 2026-05-14

### Added

- Added project-aware shell guards so installed shortcuts only run inside detected Laravel projects.
- Added readable full-stack Laravel aliases for Artisan, Sail, frontend, quality, Composer, Git, and Docker workflows.

## [0.2.1] - 2026-05-13

### Added

- Added README terminal preview artwork for alias groups and rendered shell blocks.

## [0.2.0] - 2026-05-13

### Added

- Expanded the built-in alias catalog for full-stack Laravel, PHP, frontend, Sail, quality, and Docker workflows.

## [0.1.0] - 2026-05-12

### Added

- Initial repository foundation.
- Composer package skeleton with Laravel auto-discovery.
- Pest, Pint, Larastan, Rector, and GitHub Actions quality workflow.
- Alias catalog commands: `alias-manager:list` and `alias-manager:show`.
- Shell rendering service with managed block markers.
- Safe install, uninstall, preview, and doctor commands.
