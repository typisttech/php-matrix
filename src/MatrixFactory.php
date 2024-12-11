<?php

declare(strict_types=1);

namespace TypistTech\PhpMatrix;

use TypistTech\PhpMatrix\Command\SatisfyMode;
use TypistTech\PhpMatrix\Releases\OfflineReleases;
use TypistTech\PhpMatrix\Releases\PhpNetReleases;

class MatrixFactory
{
    public function make(bool $offline, SatisfyMode $mode): MatrixInterface {
        $releases = $offline
            ? new OfflineReleases
            : new PhpNetReleases;

        return $mode->matrix($releases);
    }
}
