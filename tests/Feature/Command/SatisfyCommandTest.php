<?php

declare(strict_types=1);

namespace Tests\Feature\Command;

use Mockery;
use Symfony\Component\Console\Tester\CommandTester;
use TypistTech\PhpMatrix\Command\SatisfyCommand;
use TypistTech\PhpMatrix\Command\SatisfyMode;
use TypistTech\PhpMatrix\MatrixFactory;

covers(SatisfyCommand::class);

describe(SatisfyCommand::class, static function (): void {
    it('uses the matrix to output json', function (): void {
        [
            'matrix' => $matrix,
            'constraint' => $constraint,
            'expectedObject' => $expectedObject,
        ] = $this->mockMatrix();

        $matrixFactory = Mockery::mock(MatrixFactory::class);
        $matrixFactory->expects()
            ->make()
            ->withAnyArgs()
            ->andReturn($matrix)
            ->getMock();

        $command = new SatisfyCommand($matrixFactory);

        $tester = new CommandTester($command);
        $tester->execute(['constraint' => $constraint]);

        $tester->assertCommandIsSuccessful();

        $actualDisplay = $tester->getDisplay();
        $actualDisplayObject = json_decode($actualDisplay, false, 512, JSON_THROW_ON_ERROR);

        expect($actualDisplayObject)->toEqual($expectedObject);
    });

    it('uses the matrix factory', function (bool $expectedOnline, SatisfyMode $expectedMode): void {
        [
            'matrix' => $matrix,
            'constraint' => $constraint,
        ] = $this->mockMatrix();

        $matrixFactory = Mockery::mock(MatrixFactory::class);
        $matrixFactory->expects()
            ->make($expectedOnline, $expectedMode)
            ->andReturn($matrix)
            ->getMock();

        $command = new SatisfyCommand($matrixFactory);

        $tester = new CommandTester($command);
        $tester->execute(
            ['constraint' => $constraint, '--offline' => $expectedOnline, '--mode' => $expectedMode->value],
        );
    })->with([
        true,
        false,
    ])->with([
        SatisfyMode::Full,
        SatisfyMode::MinorOnly,
    ]);
});
