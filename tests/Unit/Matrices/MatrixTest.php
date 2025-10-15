<?php

declare(strict_types=1);

namespace Tests\Unit\Matrices;

use Mockery;
use Throwable;
use TypistTech\PhpMatrix\Exceptions\UnexpectedValueException;
use TypistTech\PhpMatrix\Matrices\Matrix;
use TypistTech\PhpMatrix\Matrices\MatrixInterface;
use TypistTech\PhpMatrix\Releases\ReleasesInterface;

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

        it('throws on invalid constraint', function () {
            $releases = Mockery::mock(ReleasesInterface::class);

            $releases->allows()
                ->all()
                ->andReturn(['1.0.0', '2.0.0']);

            $matrix = new Matrix($releases);

            $matrix->satisfiedBy('invalid constraint');
        })->throws(UnexpectedValueException::class);

        it('does not invoke ReleasesInterface::all() when invalid constraint', function () {
            $releases = Mockery::mock(ReleasesInterface::class);

            $releases->expects()
                ->all()
                ->withAnyArgs()
                ->never();

            $matrix = new Matrix($releases);

            try {
                $matrix->satisfiedBy('invalid constraint');
            } catch (Throwable $e) {
                // No-op.
            }
        });
    });
});
