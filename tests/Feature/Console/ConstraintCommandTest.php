<?php

declare(strict_types=1);

namespace Tests\Feature\Console;

use Mockery;
use Symfony\Component\Console\Tester\CommandTester;
use TypistTech\PhpMatrix\Console\ConstraintCommand;
use TypistTech\PhpMatrix\Console\MatrixFactory;
use TypistTech\PhpMatrix\Console\Mode;
use TypistTech\PhpMatrix\Console\Source;

covers(ConstraintCommand::class);

describe(ConstraintCommand::class, static function (): void {
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

        $command = new ConstraintCommand($matrixFactory);

        $tester = new CommandTester($command);
        $tester->execute(['constraint' => $constraint]);

        $tester->assertCommandIsSuccessful();

        $actualDisplay = $tester->getDisplay();
        $actualDisplayObject = json_decode($actualDisplay, false, 512, JSON_THROW_ON_ERROR);

        expect($actualDisplayObject)->toEqual($expectedObject);
    });

    it('uses the matrix factory', function (Source $expectedSource, Mode $expectedMode): void {
        [
            'matrix' => $matrix,
            'constraint' => $constraint,
        ] = $this->mockMatrix();

        $matrixFactory = Mockery::mock(MatrixFactory::class);
        $matrixFactory->expects()
            ->make($expectedSource, $expectedMode)
            ->andReturn($matrix)
            ->getMock();

        $command = new ConstraintCommand($matrixFactory);

        $tester = new CommandTester($command);
        $tester->execute(
            ['constraint' => $constraint, '--source' => $expectedSource->value, '--mode' => $expectedMode->value],
        );
    })->with(
        Source::cases()
    )->with(
        Mode::cases()
    );
});
