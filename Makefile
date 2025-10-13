export GOFLAGS=-mod=mod

.PHONY: FORCE
FORCE:;

.PHONY: vendor
vendor:
	composer install --no-dev --prefer-dist
	composer reinstall --prefer-dist '*'

bin: vendor

test-%: %
	PATH="$(shell pwd)/$*:$(shell echo $$PATH)" \
		go test -count=1 ./...

.PHONY: tests/data/versions
tests/data/versions: majors := 5 7 8
tests/data/versions:
	rm -rf tests/data/versions
	mkdir -p tests/data/versions
	$(MAKE) $(foreach major,$(majors),tests/data/versions/v$(major).json)

tests/data/versions/v%.json: FORCE
	curl 'https://www.php.net/releases/index.php?json&max=1000&version=$*' | \
		jq . > tests/data/versions/v$*.json

.PHONY: resources/all-versions.json
resources/all-versions.json: bin
	./bin/update-all-versions

.PHONY: go-generate
go-generate:
	go generate ./...

.PHONY: txtar
txtar: resources/all-versions.json go-generate bin
	UPDATE_SCRIPTS=1 \
		PATH="$(shell pwd)/bin:$(shell echo $$PATH)" \
		go test -count=1 ./...

.PHONY: update-data
update-data: resources/all-versions.json tests/data/versions txtar
