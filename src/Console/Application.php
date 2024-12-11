<?php

declare(strict_types=1);

namespace TypistTech\PhpMatrix\Console;

use Composer\InstalledVersions;
use Symfony\Component\Console\Application as ConsoleApplication;

class Application
{
    private const string NAME = 'php-matrix';

    public static function make(): ConsoleApplication
    {
        $application = new ConsoleApplication(
            self::NAME,
            InstalledVersions::getPrettyVersion('typisttech/php-matrix') ?? 'unknown',
        );

        $command = new Command;

        $application->add($command);
        $application->setDefaultCommand(
            $command->getName(),
            true
        );

        return $application;
    }
}
