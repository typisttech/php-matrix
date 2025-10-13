<?php

declare(strict_types=1);

namespace TypistTech\PhpMatrix\Console;

use Symfony\Component\Console\Application;
use Symfony\Component\Console\Attribute\Argument;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Style\SymfonyStyle;
use TypistTech\PhpMatrix\Composer;
use TypistTech\PhpMatrix\Exceptions\ExceptionInterface;

#[AsCommand(
    name: 'composer',
    description: 'List PHP versions that satisfy the required PHP constraint in composer.json',
)]
class ComposerCommand extends Command
{
    use PrintErrorTrait;

    public function __invoke(
        SymfonyStyle $io,
        Application $application,
        #[Argument(description: 'Path to composer.json file.')]
        string $path = './composer.json',
        #[SourceOption]
        string $source = Source::Auto->value,
        #[ModeOption]
        string $mode = Mode::MinorOnly->value,
    ): int {
        try {
            $composer = Composer::fromFile($path);

            $constraint = $composer->requiredPhpConstraint();

            /** @phpstan-ignore method.notFound,return.type */
            return $application->get('constraint')
                ->__invoke($io, $constraint, $source, $mode);
        } catch (ExceptionInterface $e) {
            $this->printError(
                $io,
                $e->getMessage()
            );

            return Command::FAILURE;
        }
    }
}
