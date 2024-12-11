<?php

declare(strict_types=1);

namespace TypistTech\PhpMatrix;

readonly class MinorOnlyMatrix extends Matrix implements MatrixInterface
{
    /**
     * @return string[]
     */
    public function satisfiedBy(string $constraint): array
    {
        $satisfieds = parent::satisfiedBy($constraint);

        /** @var string[] $versions */
        $versions = [];
        foreach ($satisfieds as $satisfied) {
            [$major, $minor] = explode('.', "{$satisfied}..", 3);
            $versions[] = "{$major}.{$minor}";
        }

        $versions = array_filter($versions);
        $versions = array_filter($versions, static fn (string $version) => ! str_starts_with($version, '.'));
        $versions = array_filter($versions, static fn (string $version) => ! str_ends_with($version, '.'));
        $versions = array_unique($versions);

        return array_values($versions);
    }
}
