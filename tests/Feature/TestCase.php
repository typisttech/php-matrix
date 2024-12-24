<?php

declare(strict_types=1);

namespace Tests\Feature;

use GuzzleHttp\Client as Http;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Mockery;
use Tests\TestCase as BaseTestCase;
use TypistTech\PhpMatrix\MatrixInterface;

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

    public function mockMatrix(): array
    {
        $constraint = '^1.2.3';
        $expectedObject = (object) [
            'constraint' => $constraint,
            'versions' => ['1.2.2', '1.2.4', '1.3.3', '1.4.4'],
            'lowest' => '1.2.2',
            'highest' => '1.4.4',
        ];

        $matrix = Mockery::mock(MatrixInterface::class);

        $matrix->expects()
            ->satisfiedBy($constraint)
            ->andReturn($expectedObject->versions);

        return [
            'matrix' => $matrix,
            'constraint' => $constraint,
            'expectedObject' => $expectedObject,
        ];
    }
}
