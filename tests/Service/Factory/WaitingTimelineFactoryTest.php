<?php

namespace App\Tests\Service\Factory;

use PHPUnit\Framework\TestCase;
use App\Service\Factory\WaitingTimelineFactory;
use App\Entity\WaitingTimeline;
use App\Enum\ResponseType;
use App\Exception\WaitingTimelineException;

class WaitingTimelineFactoryTest extends TestCase
{
    public function testCreateFromInputLine(): void
    {
        $inputLine = '9.1 7.14.4 P 27.11.2012 45';

        $waitingTimeline = WaitingTimelineFactory::createFromInputLine($inputLine);

        $this->assertInstanceOf(WaitingTimeline::class, $waitingTimeline);

        $this->assertEquals(9, $waitingTimeline->getServiceId());
        $this->assertEquals(1, $waitingTimeline->getVariationId());
        $this->assertEquals('7', $waitingTimeline->getQuestionTypeId());
        $this->assertEquals(14, $waitingTimeline->getCategoryId());
        $this->assertEquals(4, $waitingTimeline->getSubCategoryId());
        $this->assertEquals(ResponseType::P, $waitingTimeline->getResponseType());
        $this->assertEquals('27.11.2012', $waitingTimeline->getResponseDate());
        $this->assertEquals(45, $waitingTimeline->getWaitingTimeMinutes());
    }

    public function testInvalidInputLine(): void
    {
        $this->expectException(WaitingTimelineException::class);

        $invalidInputLine = 'Invalid input line';
        WaitingTimelineFactory::createFromInputLine($invalidInputLine);
    }
}
