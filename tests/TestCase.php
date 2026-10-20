<?php

declare(strict_types=1);

namespace Tests;

use PHPUnit\Framework\TestCase as BaseTestCase;
use RuntimeException;

abstract class TestCase extends BaseTestCase
{
    protected const string DATA_DIR = __DIR__ . '/data';

    protected const string ALL_VERSIONS_FILE = __DIR__ . '/../data/all-versions.json';

    /** @var string[] */
    protected const array RELEASES_JSONS = [
        self::DATA_DIR . '/versions/v5.json',
        self::DATA_DIR . '/versions/v7.json',
        self::DATA_DIR . '/versions/v8.json',
    ];

    /**
     * @return string[]
     */
    protected function allVersions(): array
    {
        static $allVersions = null;

        if ($allVersions === null) {
            $content = file_get_contents(self::ALL_VERSIONS_FILE);

            if (!is_string($content)) {
                $message = sprintf('Failed to read fixture file content at path "%s".', self::ALL_VERSIONS_FILE);
                throw new RuntimeException($message);
            }

            $allVersions = json_decode($content, true, 512, JSON_THROW_ON_ERROR);

            if (!is_array($allVersions) || !array_all($allVersions, static fn(mixed $v) => is_string($v))) {
                throw new RuntimeException('Failed to decode fixture into string[].');
            }
        }

        /** @var string[] $allVersions */
        return $allVersions;
    }
}
