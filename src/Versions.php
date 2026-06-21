<?php

declare(strict_types=1);

namespace TypistTech\PhpMatrix;

use Composer\Semver\Semver;
use UnexpectedValueException;

readonly class Versions
{
    /**
     * @return string[]
     */
    public static function sort(string ...$versions): array
    {
        if ($versions === []) {
            throw new UnexpectedValueException('Argument #1 ($versions) must not be empty');
        }

        return Semver::sort($versions);
    }
}
