<?php

declare(strict_types=1);

namespace TypistTech\PhpMatrix\Console;

use Symfony\Component\Console\Attribute\Option;

#[\Attribute(\Attribute::TARGET_PARAMETER)]
class ModeOption extends Option
{
    public function __construct()
    {
        parent::__construct(
            Mode::description(),
            Mode::NAME,
            null,
            array_column(Mode::cases(), 'value'),
        );
    }
}
