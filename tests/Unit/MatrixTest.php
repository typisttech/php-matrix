<?php

declare(strict_types=1);

namespace Tests\Feature\Releases;

use Mockery;
use TypistTech\PhpMatrix\Matrix;
use TypistTech\PhpMatrix\MatrixInterface;
use TypistTech\PhpMatrix\ReleasesInterface;

covers(Matrix::class);

describe(Matrix::class, static function (): void {
    it('implements ReleasesInterface', function () {
        $releases = Mockery::mock(ReleasesInterface::class);

        $matrix = new Matrix($releases);

        expect($matrix)->toBeInstanceOf(MatrixInterface::class);
    });

    describe('::satisfiedBy()', static function (): void {
        dataset('satisfied_by', static function (): array {
            $releases = [
                '1.0.0',
                '2.0.1',
                '2.0.2',
                '2.1.0',
                '2.1.1',
                '2.1.2',
                '2.2.0',
                '2.2.1',
                '2.2.2',
                '3.0.0',
            ];

            return [
                '*' => ['*', $releases, $releases],
                '2.1.2' => ['2.1.2', $releases, ['2.1.2']],
                '^2' => ['^2', $releases, ['2.0.1', '2.0.2', '2.1.0', '2.1.1', '2.1.2', '2.2.0', '2.2.1', '2.2.2']],
                '^2.1' => ['^2.1', $releases, ['2.1.0', '2.1.1', '2.1.2', '2.2.0', '2.2.1', '2.2.2']],
                '^2.1.2' => ['^2.1.2', $releases, ['2.1.2', '2.2.0', '2.2.1', '2.2.2']],
                '~2.1' => ['~2.1', $releases, ['2.1.0', '2.1.1', '2.1.2', '2.2.0', '2.2.1', '2.2.2']],
                '~2.1.1' => ['~2.1.1', $releases, ['2.1.1', '2.1.2']],
                '^2 || ^3' => [
                    '^2 || ^3',
                    $releases,
                    ['2.0.1', '2.0.2', '2.1.0', '2.1.1', '2.1.2', '2.2.0', '2.2.1', '2.2.2', '3.0.0'],
                ],
                '^9.8.7' => ['2.1.3', $releases, []],
                '~9.8.7' => ['2.1.3', $releases, []],
                '>=9.8.7' => ['2.1.3', $releases, []],
                '9.8.7' => ['2.1.3', $releases, []],
            ];
        });

        it('returns satisfying versions', function (string $constraint, array $allReleases, array $expected) {
            $releases = Mockery::mock(ReleasesInterface::class);

            $releases->expects()
                ->all()
                ->andReturn($allReleases);

            $matrix = new Matrix($releases);

            $actual = $matrix->satisfiedBy($constraint);

            expect($actual)->toBe($expected);
        })->with('satisfied_by');
    });

    describe('::lowestAndHighest()', static function (): void {
        dataset('lowest_and_highest', [
            [['1.2.3'], '1.2.3', '1.2.3'],
            [['1.2.3', '1.2.3'], '1.2.3', '1.2.3'],
            [['1.2.3', '2.2.3'], '1.2.3', '2.2.3'],
            [['1.2.3', '2.2.3', '3.2.3'], '1.2.3', '3.2.3'],

            [['1.2'], '1.2', '1.2'],
            [['1.2', '1.2'], '1.2', '1.2'],
            [['1.2', '2.2'], '1.2', '2.2'],
            [['1.2', '2.2', '3.2'], '1.2', '3.2'],
        ]);

        it(
            'returns lowest and highest versions',
            function (array $versions, string $expectedLowest, string $expectedHighest): void {
                $releases = Mockery::mock(ReleasesInterface::class);

                $matrix = new Matrix($releases);

                shuffle($versions);

                [$actualLowest, $actualHighest] = $matrix->lowestAndHighest(...$versions);

                expect($actualLowest)->toBe($expectedLowest);
                expect($actualHighest)->toBe($expectedHighest);
            }
        )->with('lowest_and_highest');
    });
});
