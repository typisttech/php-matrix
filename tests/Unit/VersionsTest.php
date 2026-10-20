<?php

declare(strict_types=1);

namespace Tests\Unit;

use TypistTech\PhpMatrix\Versions;
use UnexpectedValueException;

covers(Versions::class);

describe(Versions::class, function (): void {
    describe('::sort()', function (): void {
        dataset('sort', [
            [['1.2.3']],
            [['1.2.3', '1.2.3']],
            [['1.2.3', '2.2.3']],
            [['1.2.3', '2.2.3', '3.2.3']],
            [['1.2.3', '2.2.3', '2.2.3', '4.2.3']],

            [['1.2']],
            [['1.2', '1.2']],
            [['1.2', '2.2']],
            [['1.2', '2.2', '3.2']],
            [['1.2', '2.2', '2.2', '4.2']],
        ]);

        it('sorts the versions', function (array $versions): void {
            /** @var string[] $versions */
            $expected = $versions;

            shuffle($versions);

            $actual = Versions::sort(...$versions);

            expect($actual)->toBe($expected);
        })
            ->with('sort')
            ->repeat(10);

        it('throws exception when argument is empty', function (): void {
            Versions::sort();
        })->throws(UnexpectedValueException::class);
    });
});
