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

tests/data/releases-%.json: FORCE
	curl 'https://www.php.net/releases/index.php?json&max=1000&version=$*' | jq . > ./tests/data/releases-$*.json

resources/all-versions.json: bin tests/data/releases-5.json tests/data/releases-7.json tests/data/releases-8.json
	./bin/update-all-versions

--go-generate:
	go generate ./...

txtar: resources/all-versions.json --go-generate
	$(MAKE) UPDATE_SCRIPTS=1 test-bin
