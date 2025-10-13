<?php

declare(strict_types=1);

namespace Tests\Feature;

use GuzzleHttp\Client as Http;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Tests\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    private const array RELEASES_JSONS = [
        self::DATA_DIR.'/releases-5.json',
        self::DATA_DIR.'/releases-7.json',
        self::DATA_DIR.'/releases-8.json',
    ];

    protected function mockHttpClient(): Http
    {
        $mock = new MockHandler;

        foreach (self::RELEASES_JSONS as $json) {
            $body = file_get_contents($json);

            $mock->append(
                new Response(200, [], $body),
            );
        }

        $handlerStack = HandlerStack::create($mock);

        return new Http(['handler' => $handlerStack]);
    }
}
