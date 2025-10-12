<?php

declare(strict_types=1);

namespace TypistTech\PhpMatrix\Releases;

use RuntimeException;
use TypistTech\PhpMatrix\ReleasesInterface;

class OfflineReleases implements ReleasesInterface
{
    private const string ALL_VERSIONS_FILE = __DIR__.'/../../resources/all-versions.json';

    /**
     * @return string[]
     */
    public function all(): array
    {
        $content = file_get_contents(self::ALL_VERSIONS_FILE);
        if ($content === false) {
            throw new RuntimeException('Could not read all versions file');
        }

        /** @var string[] */
        return json_decode($content, true, 512, JSON_THROW_ON_ERROR);
    }
}
