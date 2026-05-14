<?php

declare(strict_types=1);

namespace Vardanm1993\LaravelAliasManager\Shell;

final readonly class ShellProfileManager
{
    public function __construct(
        private ShellAliasRenderer $renderer,
    ) {}

    /**
     * @param  array<string, array{description: string, aliases: array<string, string>}>  $groups
     * @param  array<string, array{group: string, command: string}>  $daily
     */
    public function install(string $file, array $groups, bool $backup = true, array $daily = []): void
    {
        $contents = $this->read($file);
        $block = $this->renderer->render($groups, $daily);

        $this->ensureParentDirectoryExists($file);

        if ($backup && is_file($file)) {
            $this->backup($file);
        }

        file_put_contents($file, $this->writeManagedBlock($contents, $block));
    }

    public function uninstall(string $file, bool $backup = true): bool
    {
        if (! is_file($file)) {
            return false;
        }

        $contents = $this->read($file);

        if (! $this->hasManagedBlock($contents)) {
            return false;
        }

        if ($backup) {
            $this->backup($file);
        }

        file_put_contents($file, $this->removeManagedBlock($contents));

        return true;
    }

    public function hasManagedBlock(string $contents): bool
    {
        return str_contains($contents, ShellAliasRenderer::BEGIN_MARKER)
            && str_contains($contents, ShellAliasRenderer::END_MARKER);
    }

    private function writeManagedBlock(string $contents, string $block): string
    {
        if ($this->hasManagedBlock($contents)) {
            return $this->replaceManagedBlock($contents, $block);
        }

        $contents = rtrim($contents);

        if ($contents === '') {
            return $block;
        }

        return $contents.PHP_EOL.PHP_EOL.$block;
    }

    private function replaceManagedBlock(string $contents, string $block): string
    {
        $pattern = sprintf(
            '/%s.*?%s\s*/s',
            preg_quote(ShellAliasRenderer::BEGIN_MARKER, '/'),
            preg_quote(ShellAliasRenderer::END_MARKER, '/'),
        );

        return (string) preg_replace($pattern, $block, $contents, 1);
    }

    private function removeManagedBlock(string $contents): string
    {
        $pattern = sprintf(
            '/\n?%s.*?%s\s*/s',
            preg_quote(ShellAliasRenderer::BEGIN_MARKER, '/'),
            preg_quote(ShellAliasRenderer::END_MARKER, '/'),
        );

        return rtrim((string) preg_replace($pattern, PHP_EOL, $contents, 1)).PHP_EOL;
    }

    private function read(string $file): string
    {
        if (! is_file($file)) {
            return '';
        }

        $contents = file_get_contents($file);

        return is_string($contents) ? $contents : '';
    }

    private function backup(string $file): void
    {
        copy($file, sprintf('%s.%s.bak', $file, date('YmdHis')));
    }

    private function ensureParentDirectoryExists(string $file): void
    {
        $directory = dirname($file);

        if (! is_dir($directory)) {
            mkdir($directory, 0755, true);
        }
    }
}
