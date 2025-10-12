<?php

declare(strict_types=1);

namespace Tests\E2E\Console;

use Symfony\Component\Console\Terminal;
use TypistTech\PhpMatrix\Console\ConstraintCommand;
use TypistTech\PhpMatrix\Console\Mode;
use TypistTech\PhpMatrix\Console\Source;

covers(ConstraintCommand::class);

describe(ConstraintCommand::class, static function (): void {
    test('terminal width is fixed in tests', function (): void {
        $terminal = new Terminal;

        // Fix terminal width for tests
        // It is configurable in phpunit.xml.
        expect($terminal->getWidth())->toBe(120);
    });

    it('success', function (string $constraint, ?string $source, ?string $mode): void {
        $applicationTester = $this->applicationTester();

        $input = array_filter([
            'constraint',
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
    ])->depends('terminal width is fixed in tests');

    // Do not use snapshot to safeguard auto-merged PRs.
    it('success without snapshot', function (): void {
        $applicationTester = $this->applicationTester();

        $applicationTester->run([
            'constraint',
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
                '7.3',
                '7.4',
                '8.1',
            ],
            'lowest' => '7.3',
            'highest' => '8.1',
        ];
        expect($actual)->toEqual($expected);
    })->depends('terminal width is fixed in tests');

    it('fails', function (string $constraint, ?string $source, ?string $mode): void {
        $applicationTester = $this->applicationTester();

        $input = array_filter([
            'constraint',
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
    ])->depends('terminal width is fixed in tests');
});
