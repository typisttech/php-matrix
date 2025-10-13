<?php

declare(strict_types=1);

namespace TypistTech\PhpMatrix\Console;

use TypistTech\PhpMatrix\Matrices\MatrixInterface;

class MatrixFactory
{
    public function make(Source $source, Mode $mode): MatrixInterface
    {
        $releases = $source->releases($mode);

        return $mode->matrix($releases);
    }
}
