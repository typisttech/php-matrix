<?php

declare(strict_types=1);

namespace TypistTech\PhpMatrix\Releases;

interface ReleasesInterface
{
    /**
     * @return string[]
     */
    public function all(): array;
}
