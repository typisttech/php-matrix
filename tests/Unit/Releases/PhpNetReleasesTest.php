<?php

declare(strict_types=1);

namespace Tests\Unit\Releases;

use GuzzleHttp\Client as Http;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use TypistTech\PhpMatrix\Releases\PhpNetReleases;

covers(PhpNetReleases::class);

describe(PhpNetReleases::class, function (): void {
    describe('::all()', function (): void {
        it('fetches all versions', function () {
            $mock = new MockHandler();
            foreach ($this::RELEASES_JSONS as $json) {
                $body = file_get_contents($json);
                $body = $body === false ? null : $body;
                $mock->append(new Response(202, [], $body));
            }
            $handlerStack = HandlerStack::create($mock);
            $http = new Http(['handler' => $handlerStack]);

            $releases = new PhpNetReleases($http);

            $actual = $releases->all();

            $expected = $this->allVersions();
            expect($actual)->toEqualCanonicalizing($expected);
        });
    });
});
