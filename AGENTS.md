## Commands

```bash
# Run PHP tests
composer pest
# Run integration tests
mise run test:bin

# Integration tests use the testscript framework; scripts live in `internal/**/*.txtar`
# To re-generate the scripts & bundled data:
mise run txtar

# Run linters
mago analyze
mago lint
composer phpstan -- analyse
mago format --check

# Format & fix linting issues
mago analyze --fix
mago lint --fix
composer phpstan -- analyse --fix
mago format
```
