<?php

declare(strict_types=1);

namespace Tests\Feature\Command;

use TypistTech\PhpMatrix\Command\SatisfyCommand;
use TypistTech\PhpMatrix\Command\SatisfyMode;

covers(SatisfyCommand::class);

describe(SatisfyCommand::class, static function (): void {
    it('success', function (string $constraint, ?bool $offline, ?string $mode): void {
        $applicationTester = $this->applicationTester();

        $input = array_filter([
            'command' => 'satisfy',
            'constraint' => $constraint,
            '--offline' => $offline,
            '--mode' => $mode,
        ], static fn($value) => $value !== null);

        $applicationTester->run($input);

        $applicationTester->assertCommandIsSuccessful();
        expect($applicationTester->getDisplay())->toMatchSnapshot();
    })->with([
        '^7.3',
        '^7.3 || ^8.1',
        '~7.3.1',
        '~7.3 || ~8.1',
        '>7.3 <8.1',
        '>=7.3 <8.1',
        '>7.3 <=8.1',
        '>=7.3 <=8.1',
        '*',
        '~7.3.1 || *',
        '>=7.3.99999 <=8.1',
        '@stable',
    ])->with([ // offline
        true,
        false,
        null,
    ])->with([
        SatisfyMode::Full->value,
        SatisfyMode::MinorOnly->value,
        null,
    ]);

    // Do not use snapshot to safeguard auto-merged PRs.
    it('success without snapshot', function (): void {
        $applicationTester = $this->applicationTester();

        $applicationTester->run([
            'command' => 'satisfy',
            'constraint' => '^7.3 || ~8.1.1',
            '--offline' => true,
            '--mode' => SatisfyMode::MinorOnly->value,
        ]);

        $applicationTester->assertCommandIsSuccessful();

        $actual = json_decode(
            $applicationTester->getDisplay(),
            true,
            512,
            JSON_THROW_ON_ERROR
        );
        $expected = [
            'constraint' => '^7.3 || ~8.1.1',
            'versions' => [
                '7.4',
                '7.3',
                '8.1'
            ],
            'lowest' => '7.3',
            'highest' => '8.1',
        ];
        expect($actual)->toEqual($expected);
    });

    it('fails', function (string $constraint, ?bool $offline, ?string $mode): void {
        $applicationTester = $this->applicationTester();

        $input = array_filter([
            'command' => 'satisfy',
            'constraint' => $constraint,
            '--offline' => $offline,
            '--mode' => $mode,
        ], static fn($value) => $value !== null);

        $applicationTester->run($input);

        expect($applicationTester->getStatusCode())->not->toBe(0);

        expect($applicationTester->getDisplay())->toMatchSnapshot();
    })->with([
        '',
        '^4',
        '^7.999',
        '>=999',
        'foo',
        'dev-master',
    ])->with([ // offline
        true,
        false,
        null,
    ])->with([
        SatisfyMode::Full->value,
        SatisfyMode::MinorOnly->value,
        null,
    ]);
});
