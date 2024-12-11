<?php

declare(strict_types=1);

namespace TypistTech\PhpMatrix;

interface MatrixInterface
{
    /**
     * @return string[]
     */
    public function satisfiedBy(string $constraint): array;

    /**
     * @return string[]
     */
    public function lowestAndHighest(string $version, string ...$versions): array;
}
