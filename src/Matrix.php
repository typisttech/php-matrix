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
}
