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
composer phpstan -- analyse

# Fix linting issues
composer phpstan -- analyse --fix --quiet || true
```
