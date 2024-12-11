<?php

declare(strict_types=1);

namespace Tests\Feature\Console;

use Symfony\Component\Console\Terminal;
use TypistTech\PhpMatrix\Console\Command;
use TypistTech\PhpMatrix\Console\Mode;
use TypistTech\PhpMatrix\Console\Source;

covers(Command::class);

describe(Command::class, static function (): void {
    test('terminal dimensions are fixed in tests', function (): void {
        $terminal = new Terminal;

        // Fix terminal dimensions for tests
        // They are configurable in phpunit.xml.
        expect($terminal->getHeight())->toBe(50);
        expect($terminal->getWidth())->toBe(80);
    });

    it('success', function (string $constraint, ?string $source, ?string $mode): void {
        $applicationTester = $this->applicationTester();

        $input = array_filter([
            'constraint' => $constraint,
            '--source' => $source,
            '--mode' => $mode,
        ], static fn ($value) => $value !== null);

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
    ])->with([
        ...array_column(Source::cases(), 'value'),
        null,
    ])->with([
        ...array_column(Mode::cases(), 'value'),
        null,
    ])->depends('terminal dimensions are fixed in tests');

    // Do not use snapshot to safeguard auto-merged PRs.
    it('success without snapshot', function (): void {
        $applicationTester = $this->applicationTester();

        $applicationTester->run([
            'constraint' => '^7.3 || ~8.1.1',
            '--source' => Source::Offline->value,
            '--mode' => Mode::MinorOnly->value,
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
                '8.1',
            ],
            'lowest' => '7.3',
            'highest' => '8.1',
        ];
        expect($actual)->toEqual($expected);
    })->depends('terminal dimensions are fixed in tests');

    it('fails', function (string $constraint, ?string $source, ?string $mode): void {
        $applicationTester = $this->applicationTester();

        $input = array_filter([
            'constraint' => $constraint,
            '--source' => $source,
            '--mode' => $mode,
        ], static fn ($value) => $value !== null);

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
    ])->with([
        ...array_column(Source::cases(), 'value'),
        'not-a-source',
        null,
    ])->with([
        ...array_column(Mode::cases(), 'value'),
        'not-a-mode',
        null,
    ])->depends('terminal dimensions are fixed in tests');
});
