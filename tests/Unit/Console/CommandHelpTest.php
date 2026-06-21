<?php

declare(strict_types=1);

namespace Tests\Unit\Console;

use Symfony\Component\Console\Application;
use TypistTech\PhpMatrix\Console\ComposerCommand;
use TypistTech\PhpMatrix\Console\ConstraintCommand;
use TypistTech\PhpMatrix\Console\Mode;
use TypistTech\PhpMatrix\Console\Source;

covers(Source::class);
covers(Mode::class);

it('renders the source & mode descriptions as option help', function (string $commandName): void {
    $application = new Application();
    $application->addCommands([
        new ComposerCommand(),
        new ConstraintCommand(),
    ]);

    $definition = $application->get($commandName)->getDefinition();

    expect($definition->getOption('source')->getDescription())
        ->toBe(Source::DESCRIPTION)
        ->and($definition->getOption('mode')->getDescription())
        ->toBe(Mode::DESCRIPTION);
})->with([
    'composer',
    'constraint',
]);
