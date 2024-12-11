<?php

declare(strict_types=1);

namespace Tests\E2E;

use Symfony\Component\Console\Tester\ApplicationTester;
use Tests\TestCase as BaseTestCase;
use TypistTech\PhpMatrix\Console\Application;

abstract class TestCase extends BaseTestCase
{
    protected function applicationTester(): ApplicationTester
    {
        $application = Application::make();
        $application->setAutoExit(false);

        return new ApplicationTester($application);
    }
}
