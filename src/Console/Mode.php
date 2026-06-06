<?php

declare(strict_types=1);

namespace TypistTech\PhpMatrix\Console;

use TypistTech\PhpMatrix\Matrices\Matrix;
use TypistTech\PhpMatrix\Matrices\MatrixInterface;
use TypistTech\PhpMatrix\Matrices\MinorOnlyMatrix;
use TypistTech\PhpMatrix\Releases\ReleasesInterface;

enum Mode: string
{
    case Full = 'full';
    case MinorOnly = 'minor-only';

    public const string DESCRIPTION = <<<'DESCRIPTION'
        Available modes:
        - <comment>full</comment>: Report all satisfying versions in MAJOR.MINOR.PATCH format
        - <comment>minor-only</comment>: Report MAJOR.MINOR versions only

        DESCRIPTION;

    public function matrix(ReleasesInterface $releases): MatrixInterface
    {
        return match ($this) {
            self::Full => new Matrix($releases),
            self::MinorOnly => new MinorOnlyMatrix($releases),
        };
    }
}
