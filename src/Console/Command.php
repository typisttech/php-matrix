<?php

declare(strict_types=1);

namespace TypistTech\PhpMatrix\Console;

use InvalidArgumentException;
use RuntimeException;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command as BaseCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'php-matrix',
    description: 'List PHP versions that satisfy the given constraint.',
)]
class Command extends BaseCommand
{
    private const string HELP = <<<'HELP'
Want to support php-matrix?
---------------------------
Here are some ways you can help:

  - Star or contribute to <info>php-matrix</info> on GitHub:
    <href=https://github.com/typisttech/php-matrix>https://github.com/typisttech/php-matrix</>

  - Sponsor <comment>Tang Rufus</comment> via GitHub:
    <href=https://github.com/sponsors/tangrufus>https://github.com/sponsors/tangrufus</>
HELP;

    private const string CONSTRAINT_ARGUMENT_NAME = 'constraint';

    private const string CONSTRAINT_ARGUMENT_DESCRIPTION = 'The version constraint.';

    private const string SOURCE_OPTION_NAME = 'source';

    private const string MODE_OPTION_NAME = 'mode';

    public function __construct(
        private readonly MatrixFactory $matrixFactory = new MatrixFactory,
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->setHelp(self::HELP)
            ->addArgument(
                self::CONSTRAINT_ARGUMENT_NAME,
                InputArgument::REQUIRED,
                self::CONSTRAINT_ARGUMENT_DESCRIPTION
            )
            ->addOption(
                self::SOURCE_OPTION_NAME,
                null,
                InputOption::VALUE_REQUIRED,
                Source::description(),
                Source::Auto->value,
            )->addOption(
                self::MODE_OPTION_NAME,
                null,
                InputOption::VALUE_REQUIRED,
                Mode::description(),
                Mode::MinorOnly->value,
            );
    }

    protected function initialize(InputInterface $input, OutputInterface $output): void
    {
        parent::initialize($input, $output);

        $sourceOpt = $input->getOption(self::SOURCE_OPTION_NAME);
        $source = Source::tryFrom($sourceOpt);
        if ($source === null) {
            $message = sprintf(
                'Error! Invalid %1$s \'%2$s\'. Available %1$ss: [%3$s]',
                self::SOURCE_OPTION_NAME,
                $sourceOpt,
                implode(', ', array_column(Source::cases(), 'value')),
            );

            throw new InvalidArgumentException($message);
        }

        $modeOpt = $input->getOption(self::MODE_OPTION_NAME);
        $mode = Mode::tryFrom($modeOpt);
        if ($mode === null) {
            $message = sprintf(
                'Error! Invalid %1$s \'%2$s\'. Available %1$ss: [%3$s]',
                self::MODE_OPTION_NAME,
                $modeOpt,
                implode(', ', array_column(Mode::cases(), 'value')),
            );

            throw new InvalidArgumentException($message);
        }
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $source = Source::from(
            $input->getOption(self::SOURCE_OPTION_NAME)
        );
        $mode = Mode::from(
            $input->getOption(self::MODE_OPTION_NAME)
        );
        $matrix = $this->matrixFactory->make($source, $mode);

        $constraint = $input->getArgument(self::CONSTRAINT_ARGUMENT_NAME);
        $versions = $matrix->satisfiedBy($constraint);
        if (empty($versions)) {
            throw new RuntimeException(
                sprintf("Error! No PHP versions could satisfy the constraint '%s'.", $constraint)
            );
        }

        [$lowest, $highest] = $matrix->lowestAndHighest(...$versions);

        $result = json_encode(
            (object) [
                self::CONSTRAINT_ARGUMENT_NAME => $constraint,
                'versions' => $versions,
                'lowest' => $lowest,
                'highest' => $highest,
            ],
            JSON_THROW_ON_ERROR | JSON_PRETTY_PRINT
        );

        $output->writeln($result);

        return BaseCommand::SUCCESS;
    }
}
