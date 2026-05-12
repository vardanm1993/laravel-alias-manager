# Release Process

## First Release Checklist

1. Ensure `develop` is green.
2. Create a `release/v0.1.0` branch from `develop`.
3. Update `CHANGELOG.md`.
4. Open a pull request from `release/v0.1.0` into `main`.
5. Wait for CI to pass.
6. Merge the release pull request.
7. Tag the release:

```bash
git tag v0.1.0
git push origin v0.1.0
```

8. Submit the GitHub repository to Packagist:

```text
https://github.com/vardanm1993/laravel-alias-manager
```

## Packagist Package

```text
vardanm1993/laravel-alias-manager
```

## Quality Commands

```bash
composer validate --strict --no-check-lock
composer quality
```
