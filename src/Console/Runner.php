<?php

declare(strict_types=1);

namespace TypistTech\PhpMatrix\Console;

class Runner
{
    private const string NAME = 'PHP Matrix';

    private const string GIT_TAG = '@git-tag@';

    public static function run(): int
    {
        $app = new Application(self::NAME, self::GIT_TAG);

        $app->addCommands([
            new ComposerCommand,
            new ConstraintCommand,
        ]);

        return $app->run();
    }
}
