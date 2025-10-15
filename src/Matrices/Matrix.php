<?php

declare(strict_types=1);

namespace TypistTech\PhpMatrix\Matrices;

use Composer\Semver\Semver;
use Composer\Semver\VersionParser;
use TypistTech\PhpMatrix\Exceptions\UnexpectedValueException as AppUnexpectedValueException;
use TypistTech\PhpMatrix\Releases\ReleasesInterface;
use UnexpectedValueException;

readonly class Matrix implements MatrixInterface
{
    public function __construct(
        private ReleasesInterface $releases,
        private VersionParser $versionParser = new VersionParser(),
    ) {}

    /**
     * @return string[]
     */
    public function satisfiedBy(string $constraint): array
    {
        try {
            // Validate constraint before passing to Semver::satisfiedBy();
            $this->versionParser->parseConstraints($constraint);

            return Semver::satisfiedBy(
                $this->releases->all(),
                $constraint
            );
        } catch (UnexpectedValueException $e) {
            throw new AppUnexpectedValueException(
                $e->getMessage(),
                previous: $e
            );
        }

    }
}
