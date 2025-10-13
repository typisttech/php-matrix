<?php

declare(strict_types=1);

namespace Tests\Feature\Releases;

use TypistTech\PhpMatrix\Composer;
use TypistTech\PhpMatrix\Exceptions\InvalidArgumentException;
use TypistTech\PhpMatrix\Exceptions\JsonException;
use TypistTech\PhpMatrix\Exceptions\UnexpectedValueException;

covers(Composer::class);

describe(Composer::class, static function (): void {
    beforeEach(function () {
        $this->tempFile = tempnam(sys_get_temp_dir(), 'composer_');
    });

    afterEach(function () {
        unlink($this->tempFile);
    });

    describe('::fromFile()', static function (): void {
        it('reads valid file', function () {
            file_put_contents($this->tempFile, '{"require":{"php":"^8.1"}}');

            $composer = Composer::fromFile($this->tempFile);

            expect($composer)->toBeInstanceOf(Composer::class);
        });

        it('throws on unreadable file', function () {
            $path = '/nonexistent/path/composer.json';

            Composer::fromFile($path);
        })->throws(InvalidArgumentException::class);

        it('throws on invalid JSON', function () {
            file_put_contents($this->tempFile, '{invalid json');

            Composer::fromFile($this->tempFile);
        })->throws(JsonException::class);
    });

    describe('::requiredPhpConstraint()', static function (): void {
        it('reads valid file', function (string $content) {
            file_put_contents($this->tempFile, $content);

            $composer = Composer::fromFile($this->tempFile);
            $actual = $composer->requiredPhpConstraint();

            expect($actual)->toBe('^1.0');
        })->with([
            '{"require":{"php":"^1.0"}}',
            '{"require":{"php":"^1.0","some/package":"^1.0"}}',
        ]);

        it('throws when no PHP constraint string is set', function (string $content) {
            file_put_contents($this->tempFile, $content);

            $composer = Composer::fromFile($this->tempFile);

            $composer->requiredPhpConstraint();
        })->throws(UnexpectedValueException::class)
            ->with([
                // No "require.php" is set.
                '{"require":{"some/package":"^1.0"}}',
                '{"require":{}}',
                '{"require":123}',
                '{"require-dev":{"php":"^1.0"}}',
                '{"php":"^1.0"}',
                '{}',
                // "require.php" is not a string.
                '{"require":{"php":null}}',
                '{"require":{"php":{}}}',
                '{"require":{"php":[]}}',
                '{"require":{"php":123}}',
                '{"require":{"php":12.3}}',
                '{"require":{"php":true}}',
                '{"require":{"php":false}}',
                // "require.php" is not a valid constraint.
                '{"require":{"php":"invalid constraint"}}',
                '{"require":{"php":"~>1.0"}}',
                '{"require":{"php":""}}',
            ]);
    });
});
