<?php

declare(strict_types=1);

namespace Tests\Feature\Releases;

use TypistTech\PhpMatrix\Releases\PhpNetReleases;
use TypistTech\PhpMatrix\ReleasesInterface;

covers(PhpNetReleases::class);

describe(PhpNetReleases::class, static function (): void {
    it('implements ReleasesInterface', function () {
        $releases = new PhpNetReleases;

        expect($releases)->toBeInstanceOf(ReleasesInterface::class);
    });
});
