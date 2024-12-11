<?php

declare(strict_types=1);

namespace Tests\Feature\Releases;

use TypistTech\PhpMatrix\Releases\OfflineReleases;
use TypistTech\PhpMatrix\ReleasesInterface;

covers(OfflineReleases::class);

describe(OfflineReleases::class, static function (): void {
    it('implements ReleasesInterface', function () {
        $releases = new OfflineReleases;

        expect($releases)->toBeInstanceOf(ReleasesInterface::class);
    });

    describe('::all()', static function (): void {
        it('fetches all versions', function () {
            $releases = new OfflineReleases;

            $actual = $releases->all();

            expect($actual)->each->toBeString();

            $expected = $this->allVersions();
            expect($actual)->toContain(...$expected);
            expect($expected)->toContain(...$actual);
        });
    });
});
