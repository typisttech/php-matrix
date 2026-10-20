<?php

declare(strict_types=1);

namespace Tests\Unit\Releases;

use TypistTech\PhpMatrix\Releases\OfflineReleases;

covers(OfflineReleases::class);

describe(OfflineReleases::class, function (): void {
    describe('::all()', function (): void {
        it('fetches all versions', function () {
            $releases = new OfflineReleases();

            $actual = $releases->all();

            $expected = $this->allVersions();
            expect($actual)->toEqualCanonicalizing($expected);
        });
    });
});
