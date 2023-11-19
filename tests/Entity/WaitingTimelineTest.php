<?php

namespace App\Tests\Entity;

use PHPUnit\Framework\TestCase;
use App\Entity\WaitingTimeline;
use App\Enum\ResponseType;
use DateTime;

class WaitingTimelineTest extends TestCase
{
    public function testConstructorAndGetters(): void
    {
        $waitingTimeline = new WaitingTimeline(
            9,
            1,
            7,
            14,
            4,
            ResponseType::P,
            DateTime::createFromFormat('Y-m-d', '2022-10-17'),
            45,
        );

        $this->assertInstanceOf(WaitingTimeline::class, $waitingTimeline);

        $this->assertEquals(9, $waitingTimeline->getServiceId());
        $this->assertEquals(1, $waitingTimeline->getVariationId());
        $this->assertEquals(7, $waitingTimeline->getQuestionTypeId());
        $this->assertEquals(14, $waitingTimeline->getCategoryId());
        $this->assertEquals(4, $waitingTimeline->getSubCategoryId());
        $this->assertEquals(ResponseType::P, $waitingTimeline->getResponseType());
        $this->assertEquals('17.10.2022', $waitingTimeline->getResponseDate()->format('d.m.Y'));
        $this->assertEquals(45, $waitingTimeline->getWaitingTimeMinutes());
    }
}
