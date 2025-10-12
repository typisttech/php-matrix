<?php

declare(strict_types=1);

namespace TypistTech\PhpMatrix\Console;

use Symfony\Component\Console\Exception\InvalidArgumentException;

trait FromNameTrait
{
    public static function fromValue(string $value): self
    {
        $case = self::tryFrom($value);

        if ($case === null) {
            $message = sprintf(
                '[ERROR] Invalid --%1$s "%2$s". Available %1$ss: [%3$s]',
                self::NAME,
                $value,
                implode(', ', array_column(self::cases(), 'value')),
            );
            throw new InvalidArgumentException($message);
        }

        return $case;
    }
}
