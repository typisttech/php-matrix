<?php

declare(strict_types=1);

namespace TypistTech\PhpMatrix;

interface MatrixInterface
{
    /**
     * @return string[]
     */
    public function satisfiedBy(string $constraint): array;
}
