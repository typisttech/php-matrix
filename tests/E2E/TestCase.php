<?php

declare(strict_types=1);

namespace Tests\E2E;

use Symfony\Component\Console\Application;
use Symfony\Component\Console\Tester\ApplicationTester;
use Tests\TestCase as BaseTestCase;
use TypistTech\PhpMatrix\Command\SatisfyCommand;

abstract class TestCase extends BaseTestCase
{
    protected function applicationTester(): ApplicationTester
    {
        $application = new Application('php-matrix', 'testing');
        $application->setAutoExit(false);

        $application->add(new SatisfyCommand);

        return new ApplicationTester($application);
    }
}
