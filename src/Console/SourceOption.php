<?php

declare(strict_types=1);

namespace TypistTech\PhpMatrix\Console;

use Attribute;
use Symfony\Component\Console\Attribute\Option;

#[Attribute(Attribute::TARGET_PARAMETER)]
class SourceOption extends Option
{
    public function __construct()
    {
        parent::__construct(
            Source::description(),
            Source::NAME,
            null,
            array_column(Source::cases(), 'value'),
        );
    }
}
