<?php

declare(strict_types=1);

namespace TypistTech\PhpMatrix\Console;

use Symfony\Component\Console\Exception\InvalidArgumentException;
use TypistTech\PhpMatrix\Matrix;
use TypistTech\PhpMatrix\MatrixInterface;
use TypistTech\PhpMatrix\MinorOnlyMatrix;
use TypistTech\PhpMatrix\ReleasesInterface;

enum Mode: string
{
    case Full = 'full';
    case MinorOnly = 'minor-only';

    use FromNameTrait;

    public const string NAME = 'mode';

    public function matrix(ReleasesInterface $releases): MatrixInterface
    {
        return match ($this) {
            self::Full => new Matrix($releases),
            self::MinorOnly => new MinorOnlyMatrix($releases),
        };
    }

    public static function description(): string
    {
        $desc = 'Available modes:'.PHP_EOL;

        foreach (self::cases() as $mode) {
            $desc .= "- <comment>{$mode->value}</comment>: {$mode->explanation()}".PHP_EOL;
        }

        $desc .= PHP_EOL;

        return $desc;
    }

    private function explanation(): string
    {
        return match ($this) {
            self::Full => 'Report all satisfying versions in MAJOR.MINOR.PATCH format',
            self::MinorOnly => 'Report MAJOR.MINOR versions only',
        };
    }
}
