<?php

declare(strict_types=1);

namespace TypistTech\PhpMatrix;

use Composer\Semver\VersionParser;
use TypistTech\PhpMatrix\Exceptions\InvalidArgumentException;
use TypistTech\PhpMatrix\Exceptions\JsonException;
use TypistTech\PhpMatrix\Exceptions\UnexpectedValueException;

readonly class Composer
{
    public static function fromFile(string $path): self
    {
        if (! is_readable($path)) {
            $message = sprintf(
                'The file is not readable or does not exist at path "%s".',
                $path,
            );
            throw new InvalidArgumentException($message);
        }

        $content = (string) file_get_contents($path);

        if (! json_validate($content)) {
            $message = sprintf(
                'The file is not a valid JSON at path "%s".',
                $path,
            );
            throw new JsonException($message);
        }

        /** @var mixed[] $data */
        $data = json_decode($content, true, 512, JSON_THROW_ON_ERROR);

        return new self($data);
    }

    /**
     * @param  mixed[]  $data
     */
    private function __construct(
        private array $data,
        private VersionParser $versionParser = new VersionParser,
    ) {}

    public function requiredPhpConstraint(): string
    {
        $require = $this->data['require'] ?? [];
        if (! is_array($require)) {
            $require = [];
        }
        $constraint = $require['php'] ?? null;

        if (! is_string($constraint)) {
            throw new UnexpectedValueException('The "require.php" field is not set or not a string.');
        }

        try {
            $this->versionParser->parseConstraints($constraint);
        } catch (\UnexpectedValueException $e) {
            $message = sprintf(
                'The "require.php" field is not a valid version constraint: %s',
                $e->getMessage(),
            );
            throw new UnexpectedValueException($message, previous: $e);
        }

        return $constraint;
    }
}
