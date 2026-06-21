<?php

declare(strict_types=1);

namespace TypistTech\PhpMatrix\Console;

use Symfony\Component\Console\Attribute\Argument;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Attribute\Option;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Style\SymfonyStyle;
use TypistTech\PhpMatrix\Exceptions\ExceptionInterface;
use TypistTech\PhpMatrix\Exceptions\RuntimeException;
use TypistTech\PhpMatrix\Versions;

#[AsCommand(name: 'constraint', description: 'List PHP versions that satisfy the given constraint')]
class ConstraintCommand extends Command
{
    use PrintErrorTrait;

    public function __construct(
        private readonly MatrixFactory $matrixFactory = new MatrixFactory(),
    ) {
        parent::__construct();
    }

    public function __invoke(
        SymfonyStyle $io,
        #[Argument(description: 'The version constraint.')]
        string $constraint,
        #[Option(description: Source::DESCRIPTION)]
        Source $source = Source::Auto,
        #[Option(description: Mode::DESCRIPTION)]
        Mode $mode = Mode::MinorOnly,
    ): int {
        try {
            $matrix = $this->matrixFactory->make($source, $mode);

            $versions = $matrix->satisfiedBy($constraint);
            if ($versions === []) {
                throw new RuntimeException(sprintf('No PHP versions could satisfy the constraint "%s".', $constraint));
            }

            $sorted = Versions::sort(...$versions);

            $result = json_encode(
                (object) [
                    'constraint' => $constraint,
                    'versions' => $sorted,
                    'lowest' => array_first($sorted),
                    'highest' => array_last($sorted),
                ],
                JSON_THROW_ON_ERROR | JSON_PRETTY_PRINT,
            );

            $io->writeln($result);

            return Command::SUCCESS;
        } catch (ExceptionInterface $e) {
            $this->printError($io, $e->getMessage());

            return Command::FAILURE;
        }
    }
}
