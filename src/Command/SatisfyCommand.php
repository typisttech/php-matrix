<?php

declare(strict_types=1);

namespace TypistTech\PhpMatrix\Command;

use InvalidArgumentException;
use RuntimeException;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use TypistTech\PhpMatrix\MatrixFactory;

#[AsCommand(
    name: 'satisfy',
    description: 'List a PHP version matrix that satisfies the given constraint.',
)]
class SatisfyCommand extends Command
{
    public function __construct(
        private readonly MatrixFactory $matrixFactory = new MatrixFactory,
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->setHelp('TODO...')
            ->addArgument('constraint', InputArgument::REQUIRED, 'The version constraint.')
            ->addOption(
                'offline',
                null,
                InputOption::VALUE_NONE,
                'Whether to use hardcoded data instead of fetching from php.net.',
            )
            ->addOption(
                'mode',
                null,
                InputOption::VALUE_REQUIRED,
                SatisfyMode::description(),
                SatisfyMode::MinorOnly->value,
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $constraint = $input->getArgument('constraint');

        $mode = SatisfyMode::tryFrom($input->getOption('mode'));
        if ($mode === null) {
            throw new InvalidArgumentException('Error! Invalid --mode.');
        }

        $matrix = $this->matrixFactory->make(
            $input->getOption('offline'),
            $mode,
        );

        $versions = $matrix->satisfiedBy($constraint);

        if (empty($versions)) { // TODO: Test me.
            throw new RuntimeException('Error! No versions could satisfy the constraint.');
        }

        [$lowest, $highest] = $matrix->lowestAndHighest(...$versions);

        $result = json_encode(
            (object) [
                'constraint' => $constraint,
                'versions' => $versions,
                'lowest' => $lowest,
                'highest' => $highest,
            ],
            JSON_THROW_ON_ERROR | JSON_PRETTY_PRINT
        );

        $output->writeln($result);

        return Command::SUCCESS;
    }
}
