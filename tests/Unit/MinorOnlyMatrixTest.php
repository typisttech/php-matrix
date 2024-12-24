<?php

declare(strict_types=1);

namespace Tests\Feature\Releases;

use Mockery;
use TypistTech\PhpMatrix\MatrixInterface;
use TypistTech\PhpMatrix\MinorOnlyMatrix;
use TypistTech\PhpMatrix\ReleasesInterface;

covers(MinorOnlyMatrix::class);

describe(MinorOnlyMatrix::class, static function (): void {
    it('implements ReleasesInterface', function () {
        $releases = Mockery::mock(ReleasesInterface::class);

        $matrix = new MinorOnlyMatrix($releases);

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
                '*' => ['*', $releases, ['1.0', '2.0', '2.1', '2.2', '3.0']],
                '2.1.2' => ['2.1.2', $releases, ['2.1']],
                '^2' => ['^2', $releases, ['2.0', '2.1', '2.2']],
                '^2.1' => ['^2.1', $releases, ['2.1', '2.2']],
                '^2.1.2' => ['^2.1.2', $releases, ['2.1', '2.2']],
                '~2.1' => ['~2.1', $releases, ['2.1', '2.2']],
                '~2.1.1' => ['~2.1.1', $releases, ['2.1']],
                '^2 || ^3' => ['^2 || ^3', $releases, ['2.0', '2.1', '2.2', '3.0']],
                '^9.8.7' => ['2.1.3', $releases, []],
                '~9.8.7' => ['2.1.3', $releases, []],
                '>=9.8.7' => ['2.1.3', $releases, []],
                '9.8.7' => ['2.1.3', $releases, []],
            ];
        });

        it('returns satisfying versions', function (string $constraint, array $allReleases, array $expected): void {
            $releases = Mockery::mock(ReleasesInterface::class);
            $releases->expects()
                ->all()
                ->andReturn($allReleases);

            $matrix = new MinorOnlyMatrix($releases);

            $actual = $matrix->satisfiedBy($constraint);

            expect($actual)->toBe($expected);
        })->with('satisfied_by');
    });
});
