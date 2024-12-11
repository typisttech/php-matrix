<?php

declare(strict_types=1);

namespace Tests\Feature\Releases;

use TypistTech\PhpMatrix\Releases\PhpNetReleases;

covers(PhpNetReleases::class);

describe(PhpNetReleases::class, static function (): void {
    describe('::all()', static function (): void {
        it('fetches all versions', function () {
            $http = $this->mockHttpClient();

            $releases = new PhpNetReleases($http);

            $actual = $releases->all();

            expect($actual)->each->toBeString();

            $expected = $this->allVersions();
            expect($actual)->toContain(...$expected);
            expect($expected)->toContain(...$actual);
        });
    });
});
