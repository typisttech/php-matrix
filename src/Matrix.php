<?php

declare(strict_types=1);

namespace TypistTech\PhpMatrix;

use Composer\Semver\Semver;

readonly class Matrix implements MatrixInterface
{
    public function __construct(
        private ReleasesInterface $releases,
    ) {}

    /**
     * @return string[]
     */
    public function satisfiedBy(string $constraint): array
    {
        return Semver::satisfiedBy(
            $this->releases->all(),
            $constraint
        );
    }

    public function lowestAndHighest(string $version, string ...$versions): array
    {
        if (empty($versions)) {
            return [$version, $version];
        }

        $sorted = Semver::sort([$version, ...$versions]);
        $count = count($sorted);

        return [$sorted[0], $sorted[$count - 1]];
    }
}
