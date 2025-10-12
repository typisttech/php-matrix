<?php

declare(strict_types=1);

namespace TypistTech\PhpMatrix\Console;

use Symfony\Component\Console\Attribute\Option;
use Symfony\Component\Console\Exception\InvalidArgumentException;
use TypistTech\PhpMatrix\Releases\OfflineReleases;
use TypistTech\PhpMatrix\Releases\PhpNetReleases;
use TypistTech\PhpMatrix\ReleasesInterface;

enum Source: string
{
    case Auto = 'auto';
    case PhpNet = 'php.net';
    case Offline = 'offline';

    use FromNameTrait;

    public const string NAME = 'source';

    public function releases(Mode $mode): ReleasesInterface
    {
        if ($this === self::Auto) {
            return match ($mode) {
                Mode::Full => new PhpNetReleases,
                Mode::MinorOnly => new OfflineReleases,
            };
        }

        return match ($this) {
            self::PhpNet => new PhpNetReleases,
            self::Offline => new OfflineReleases,
        };
    }

    public static function description(): string
    {
        $desc = 'Available sources:' . PHP_EOL;

        foreach (self::cases() as $source) {
            $desc .= "- <comment>{$source->value}</comment>: {$source->explanation()}" . PHP_EOL;
        }

        $desc .= PHP_EOL;

        return $desc;
    }

    private function explanation(): string
    {
        return match ($this) {
            self::Auto => 'Use <comment>offline</comment> in <comment>minor-only</comment> mode. Otherwise, fetch from <comment>php.net</comment>',
            self::PhpNet => 'Fetch releases information from <href=https://www.php.net/releases/index.php>php.net</>',
            self::Offline => 'Use <href=https://github.com/typisttech/php-matrix/blob/main/resources/all-versions.json>hardcoded releases</> information',
        };
    }
}
