<?php

declare(strict_types=1);

namespace Tests\Feature\Releases;

use TypistTech\PhpMatrix\Versions;
use UnexpectedValueException;

covers(Versions::class);

describe(Versions::class, static function (): void {
    describe('::sort()', static function (): void {
        dataset('sort', [
            [['1.2.3']],
            [['1.2.3', '1.2.3']],
            [['1.2.3', '2.2.3']],
            [['1.2.3', '2.2.3', '3.2.3']],

            [['1.2']],
            [['1.2', '1.2']],
            [['1.2', '2.2']],
            [['1.2', '2.2', '3.2']],
        ]);

        it('sorts the versions', function (array $versions): void {
            $expected = $versions;

            shuffle($versions);

            $actual = Versions::sort(...$versions);

            expect($actual)->toBe($expected);
        })->with('sort');

        it('throws exception when argument is empty', function (): void {
            Versions::sort();
        })->throws(UnexpectedValueException::class);
    });

    describe('::lowest()', static function (): void {
        dataset('lowest', [
            [['1.2.3'], '1.2.3'],
            [['1.2.3', '1.2.3'], '1.2.3'],
            [['1.2.3', '2.2.3'], '1.2.3'],
            [['1.2.3', '2.2.3', '3.2.3'], '1.2.3'],

            [['1.2'], '1.2'],
            [['1.2', '1.2'], '1.2'],
            [['1.2', '2.2'], '1.2'],
            [['1.2', '2.2', '3.2'], '1.2'],
        ]);

        it('returns the lowest version', function (array $versions, string $expected): void {
            shuffle($versions);

            $actual = Versions::lowest(...$versions);

            expect($actual)->toBe($expected);
        })->with('lowest');

        it('throws exception when argument is empty', function (): void {
            Versions::lowest();
        })->throws(UnexpectedValueException::class);
    });

    describe('::highest()', static function (): void {
        dataset('highest', [
            [['1.2.3'], '1.2.3'],
            [['1.2.3', '1.2.3'], '1.2.3'],
            [['1.2.3', '2.2.3'], '2.2.3'],
            [['1.2.3', '2.2.3', '3.2.3'], '3.2.3'],

            [['1.2'], '1.2'],
            [['1.2', '1.2'], '1.2'],
            [['1.2', '2.2'], '2.2'],
            [['1.2', '2.2', '3.2'], '3.2'],
        ]);

        it('return the highest version', function (array $versions, string $expected): void {
            shuffle($versions);

            $actual = Versions::highest(...$versions);

            expect($actual)->toBe($expected);
        })->with('highest');

        it('throws exception when argument is empty', function (): void {
            Versions::highest();
        })->throws(UnexpectedValueException::class);
    });
});
