<?php

declare(strict_types=1);

namespace TypistTech\PhpMatrix\Console;

use Symfony\Component\Console\Application as SymfonyConsoleApplication;
use Symfony\Component\Console\Helper\FormatterHelper;

class Application extends SymfonyConsoleApplication
{
    private const BANNER = <<<BANNER
         ____  _   _ ____    __  __       _        _      
        |  _ \| | | |  _ \  |  \/  | __ _| |_ _ __(_)_  __
        | |_) | |_| | |_) | | |\/| |/ _` | __| '__| \ \/ /
        |  __/|  _  |  __/  | |  | | (_| | |_| |  | |>  < 
        |_|   |_| |_|_|     |_|  |_|\__,_|\__|_|  |_/_/\_\
        BANNER;

    public const BUILD_TIMESTAMP = '@datetime@';

    public function getLongVersion(): string
    {
        $longVersion = self::BANNER;
        $longVersion .= PHP_EOL.PHP_EOL;

        $app = sprintf(
            '%-15s <info>%s</info> %s',
            $this->getName(),
            $this->getVersion(),
            self::BUILD_TIMESTAMP,
        );
        $longVersion .= $app;

        $githubUrl = sprintf(
            '<href=https://github.com/typisttech/php-matrix/releases/tag/%1$s>https://github.com/typisttech/php-matrix/releases/tag/%1$s</>',
            $this->getVersion(),
        );
        // https://github.com/box-project/box/blob/b0123f358f2a32488c92e09bf56f16d185e4e3cb/src/Configuration/Configuration.php#L2116
        if ((bool) preg_match('/^(?<tag>.+)-\d+-g(?<hash>[a-f0-9]{7})$/', $this->getVersion(), $matches)) {
            // Not on a tag.
            $githubUrl = sprintf(
                '<href=https://github.com/typisttech/php-matrix/compare/%1$s...%2$s>https://github.com/typisttech/php-matrix/compare/%1$s...%2$s</>',
                $matches['tag'],
                $matches['hash'],
            );
        }
        $longVersion .= PHP_EOL.$githubUrl;

        $longVersion .= PHP_EOL.PHP_EOL.'<comment>PHP:</>';

        $phpVersion = sprintf(
            '%-15s %s',
            'Version',
            PHP_VERSION,
        );
        $longVersion .= PHP_EOL.$phpVersion;

        $phpSapi = sprintf(
            '%-15s %s',
            'SAPI',
            PHP_SAPI,
        );
        $longVersion .= PHP_EOL.$phpSapi;

        $longVersion .= PHP_EOL.PHP_EOL.'<comment>Support PHP Matrix:</>';

        $supportBlock = (new FormatterHelper)
            ->formatBlock(
                [
                    'If you find this tool useful, please consider supporting its development.',
                    'Every contribution counts, regardless how big or small.',
                    'I am eternally grateful to all sponsors who fund my open source journey.',
                ],
                'question',
                true,
            );
        $longVersion .= PHP_EOL.$supportBlock;

        $sponsorUrl = sprintf(
            '%1$-15s <href=%2$s>%2$s</>',
            'GitHub Sponsor',
            'https://github.com/sponsors/tangrufus',
        );
        $longVersion .= PHP_EOL.PHP_EOL.$sponsorUrl;

        $longVersion .= PHP_EOL.PHP_EOL.'<comment>Hire Tang Rufus:</>';

        $hireBlock = (new FormatterHelper)
            ->formatBlock(
                [
                    'I am looking for my next role, freelance or full-time.',
                    'If you find this tool useful, I can build you more weird stuffs like this.',
                    "Let's talk if you are hiring PHP / Ruby / Go developers.",
                ],
                'error',
                true,
            );
        $longVersion .= PHP_EOL.$hireBlock;

        $sponsorUrl = sprintf(
            '%1$-15s <href=%2$s>%2$s</>',
            'Contact',
            'https://typist.tech/contact/',
        );
        $longVersion .= PHP_EOL.PHP_EOL.$sponsorUrl;

        return $longVersion;
    }
}
