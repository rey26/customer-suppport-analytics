<?php

namespace App\Tests\Service;

use App\Service\MainService;
use App\Service\WaitingTimelineService;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class MainServiceTest extends TestCase
{
    public function testParseInputValid(): void
    {
        $mainService = new MainService(new WaitingTimelineService());
        $input = "7
            C 1.1 8.15.1 P 15.10.2012 83
            C 1 10.1 P 01.12.2012 65
            C 1.1 5.5.1 P 01.11.2012 117
            D 1.1 8 P 01.01.2012-01.12.2012
            C 3 10.2 N 02.10.2012 100
            D 1 * P 8.10.2012-20.11.2012
            D 3 10 P 01.12.2012";

        $mainService->parseInput($input);

        $this->assertCount(7, $mainService->getParsedInput());
    }

    public function testParseInputInvalid(): void
    {
        $this->expectException(InvalidArgumentException::class);

        $mainService = new MainService(new WaitingTimelineService());
        $input = "6
            C 1.1 8.15.1 P 15.10.2012 83
            C 1 10.1 P 01.12.2012 65
            C 1.1 5.5.1 P 01.11.2012 117
            D 1.1 8 P 01.01.2012-01.12.2012
            C 3 10.2 N 02.10.2012 100
            D 1 * P 8.10.2012-20.11.2012
            D 3 10 P 01.12.2012";

        $mainService->parseInput($input);
    }

    public function testHandleInput(): void
    {
        $mainService = new MainService(new WaitingTimelineService());
        $input = "7
            C 1.1 8.15.1 P 15.10.2012 83
            C 1 10.1 P 01.12.2012 65
            C 1.1 5.5.1 P 01.11.2012 117
            D 1.1 8 P 01.01.2012-01.12.2012
            C 3 10.2 N 02.10.2012 100
            D 1 * P 8.10.2012-20.11.2012
            D 3 10 P 01.12.2012";

        $expectedOutput = 83 . PHP_EOL . 100 . PHP_EOL . '-';

        $output = $mainService->parseInput($input)->handleInput()->getOutput();

        $this->assertEquals($expectedOutput, $output);
    }
}
