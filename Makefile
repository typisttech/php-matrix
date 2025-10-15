export GOFLAGS=-mod=mod

.PHONY: FORCE
FORCE:;

.PHONY: vendor
vendor:
	composer install --no-dev --prefer-dist
	composer reinstall --prefer-dist '*'

bin: vendor

phar: vendor
	box compile
	box verify phar/php-matrix
	box info phar/php-matrix
	php phar/php-matrix --version

test-%: %
	PATH="$(shell pwd)/$*:$(shell echo $$PATH)" \
		go test -count=1 ./...

.PHONY: tests/data/versions
tests/data/versions: MAJORS := 5 7 8
tests/data/versions:
	rm -rf tests/data/versions
	mkdir -p tests/data/versions
	$(MAKE) $(foreach MAJOR,$(MAJORS),tests/data/versions/v$(MAJOR).json)

tests/data/versions/v%.json: FORCE
	curl 'https://www.php.net/releases/index.php?json&max=1000&version=$*' | \
		jq . > tests/data/versions/v$*.json

.PHONY: data/all-versions.json
data/all-versions.json: bin
	./bin/update-all-versions

.PHONY: version-data
version-data: data/all-versions.json tests/data/versions

.PHONY: txtar
txtar: data/all-versions.json
	go generate ./...
	UPDATE_SCRIPTS=1 $(MAKE) test-bin
