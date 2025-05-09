<?php

namespace Tests;

use PHPUnit\Framework\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    protected const string DATA_DIR = __DIR__.'/data';

    protected const string ALL_VERSIONS_FILE = __DIR__.'/../resources/all-versions.json';

    /**
     * @return string[]
     */
    protected function allVersions(): array
    {
        static $allVersions = null;
        if ($allVersions === null) {
            $content = file_get_contents(self::ALL_VERSIONS_FILE);

            $allVersions = json_decode($content, true, 512, JSON_THROW_ON_ERROR);
        }

        return $allVersions;
    }
}
