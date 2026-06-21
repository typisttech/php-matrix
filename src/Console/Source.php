<?php

declare(strict_types=1);

namespace TypistTech\PhpMatrix\Console;

use TypistTech\PhpMatrix\Releases\OfflineReleases;
use TypistTech\PhpMatrix\Releases\PhpNetReleases;
use TypistTech\PhpMatrix\Releases\ReleasesInterface;

enum Source: string
{
    case Auto = 'auto';
    case PhpNet = 'php.net';
    case Offline = 'offline';

    public const string DESCRIPTION = <<<'DESCRIPTION'
        Available sources:
        - <comment>auto</comment>: Use <comment>offline</comment> in <comment>minor-only</comment> mode. Otherwise, fetch from <comment>php.net</comment>
        - <comment>php.net</comment>: Fetch releases information from <href=https://www.php.net/releases/index.php>php.net</>
        - <comment>offline</comment>: Use <href=https://github.com/typisttech/php-matrix/blob/main/data/all-versions.json>hardcoded releases</> information

        DESCRIPTION;

    public function releases(Mode $mode): ReleasesInterface
    {
        if ($this === self::Auto) {
            return match ($mode) {
                Mode::Full => new PhpNetReleases(),
                Mode::MinorOnly => new OfflineReleases(),
            };
        }

        return match ($this) {
            self::PhpNet => new PhpNetReleases(),
            self::Offline => new OfflineReleases(),
        };
    }
}
