<?php

declare(strict_types=1);

namespace Tests\Unit\Releases;

use GuzzleHttp\Client as Http;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use TypistTech\PhpMatrix\Releases\PhpNetReleases;
use TypistTech\PhpMatrix\Releases\ReleasesInterface;

covers(PhpNetReleases::class);

describe(PhpNetReleases::class, static function (): void {
    it('implements ReleasesInterface', function () {
        $releases = new PhpNetReleases;

        expect($releases)->toBeInstanceOf(ReleasesInterface::class);
    });

    describe('::all()', static function (): void {
        it('fetches all versions', function () {
            $mock = new MockHandler;
            foreach ($this::RELEASES_JSONS as $json) {
                $body = file_get_contents($json);
                $mock->append(
                    new Response(202, [], $body),
                );
            }
            $handlerStack = HandlerStack::create($mock);
            $http = new Http(['handler' => $handlerStack]);

            $releases = new PhpNetReleases($http);

            $actual = $releases->all();

            expect($actual)->each->toBeString();

            $expected = $this->allVersions();

            expect($actual)->toContain(...$expected);
            expect($expected)->toContain(...$actual);
        });
    });
});
