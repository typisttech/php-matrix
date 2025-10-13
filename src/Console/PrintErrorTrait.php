<?php

declare(strict_types=1);

namespace TypistTech\PhpMatrix\Console;

use Symfony\Component\Console\Style\SymfonyStyle;

trait PrintErrorTrait
{
    private function printError(SymfonyStyle $io, string $message): void
    {
        $io->getErrorStyle()
            ->error($message);
    }
}
