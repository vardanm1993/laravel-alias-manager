<?php

declare(strict_types=1);

namespace Vardanm1993\LaravelAliasManager\Shell;

final class ShellProfileResolver
{
    public function resolve(?string $explicitFile = null): ?string
    {
        if (is_string($explicitFile) && $explicitFile !== '') {
            return $explicitFile;
        }

        $home = getenv('HOME');

        if (! is_string($home) || $home === '') {
            return null;
        }

        $shell = basename((string) getenv('SHELL'));

        return match ($shell) {
            'bash' => $home.'/.bashrc',
            'zsh' => $home.'/.zshrc',
            default => null,
        };
    }
}
