# Repository Rules

## Branches

`main` is for stable releases only.

`develop` is the integration branch for active development.

All work must happen in focused branches created from `develop`.

## Branch Names

- `feat/*` for new features
- `fix/*` for bug fixes
- `docs/*` for documentation
- `test/*` for tests
- `refactor/*` for internal improvements
- `ci/*` for GitHub Actions and automation
- `chore/*` for repository and maintenance work
- `release/*` for release preparation

## Pull Requests

Every change must go through a pull request.

Pull requests should include:

- clear title
- focused scope
- why the change is needed
- what changed
- commands run
- test status

## Commit Messages

Use Conventional Commit messages.

Examples:

```text
chore: add repository identity
ci: add composer quality workflow
feat(installer): add install command
fix(shell): prevent duplicate managed block
test(package): cover service provider config loading
docs(readme): improve installation guide
```

## Required Checks

Current required checks:

```text
Tests PHP 8.3
Tests PHP 8.4
Tests PHP 8.5
```

Future checks:

```text
Code Style
Static Analysis
Rector Dry Run
```

## Recommended Branch Protection

### `main`

- Require pull request before merging
- Require approvals
- Require status checks to pass
- Require branches to be up to date
- Require conversation resolution before merging
- Do not allow force pushes
- Do not allow deletions

### `develop`

- Require pull request before merging
- Require status checks to pass
- Require branches to be up to date
- Require conversation resolution before merging
- Do not allow force pushes
- Do not allow deletions
