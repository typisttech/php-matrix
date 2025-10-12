<?php

declare(strict_types=1);

namespace TypistTech\PhpMatrix\Console;

use Symfony\Component\Console\Attribute\Argument;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Style\SymfonyStyle;
use TypistTech\PhpMatrix\Versions;
use UnexpectedValueException;

#[AsCommand(
    name: 'constraint',
    description: 'List PHP versions that satisfy the given constraint',
)]
class ConstraintCommand extends Command
{
    use PrintErrorTrait;

    public function __construct(
        private readonly MatrixFactory $matrixFactory = new MatrixFactory,
    ) {
        parent::__construct();
    }

    public function __invoke(
        SymfonyStyle $io,
        #[Argument(description: 'The version constraint.')]
        string $constraint,
        #[SourceOption]
        string $source = Source::Auto->value,
        #[ModeOption]
        string $mode = Mode::MinorOnly->value,
    ): int {
        $matrix = $this->matrixFactory->make(
            Source::fromValue($source),
            Mode::fromValue($mode),
        );

        try {
            $versions = $matrix->satisfiedBy($constraint);
        } catch (UnexpectedValueException $e) {
            $this->printError(
                $io,
                $e->getMessage()
            );

            return Command::FAILURE;
        }

        if ($versions === []) {
            $this->printError(
                $io,
                sprintf('No PHP versions could satisfy the constraint "%s".', $constraint)
            );

            return Command::FAILURE;
        }

        $result = json_encode(
            (object) [
                'constraint' => $constraint,
                'versions' => Versions::sort(...$versions),
                'lowest' => Versions::lowest(...$versions),
                'highest' => Versions::highest(...$versions),
            ],
            JSON_THROW_ON_ERROR | JSON_PRETTY_PRINT
        );

        $io->writeln($result);

        return Command::SUCCESS;
    }
}
