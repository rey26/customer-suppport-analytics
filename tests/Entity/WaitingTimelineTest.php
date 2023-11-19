<?php

namespace App\Tests\Entity;

use PHPUnit\Framework\TestCase;
use App\Entity\WaitingTimeline;
use App\Enum\ResponseType;

class WaitingTimelineTest extends TestCase
{
    public function testConstructorAndGetters(): void
    {
        $waitingTimeline = new WaitingTimeline(9, 1, '7', 14, 4, ResponseType::P, '27.11.2012', 45);

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
}
