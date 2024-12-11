<?php

declare(strict_types=1);

namespace Tests\E2E\Releases;

use TypistTech\PhpMatrix\Releases\PhpNetReleases;

covers(PhpNetReleases::class);

describe(PhpNetReleases::class, static function (): void {
    describe('::all()', static function (): void {
        it('fetches all versions', function () {
            $releases = new PhpNetReleases;

            $actual = $releases->all();

            expect($actual)->each->toBeString();
            expect($actual)->toMatchSnapshot();
        })->group('resource');
    });
});
