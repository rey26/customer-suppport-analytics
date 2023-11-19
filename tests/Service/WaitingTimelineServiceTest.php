<?php

namespace App\Tests\Service;

use PHPUnit\Framework\TestCase;
use App\Service\WaitingTimelineService;
use App\Entity\Query;
use App\Entity\WaitingTimeline;
use App\Enum\ResponseType;
use DateTime;

class WaitingTimelineServiceTest extends TestCase
{
    public function testAddEntity()
    {
        $waitingTimelineService = new WaitingTimelineService();
        $waitingTimeline = new WaitingTimeline(1, 2, 3, 3, 4, ResponseType::P, new DateTime('2023-01-01'), 10);

        $result = $waitingTimelineService->addEntity($waitingTimeline);

        $this->assertInstanceOf(WaitingTimelineService::class, $result);
    }

    public function testResetEntities()
    {
        $waitingTimelineService = new WaitingTimelineService();
        $waitingTimeline = new WaitingTimeline(1, 2, 3, 3, 4, ResponseType::N, new DateTime('2023-01-01'), 10);
        $waitingTimelineService->addEntity($waitingTimeline);

        $result = $waitingTimelineService->resetEntities();

        $this->assertInstanceOf(WaitingTimelineService::class, $result);
        $this->assertEmpty($waitingTimelineService->findEntitiesByQuery(
            new Query(null, null, null, null, null, ResponseType::N, new DateTime()),
        ));
    }

    public function testFindEntitiesByQuery()
    {
        $waitingTimelineService = new WaitingTimelineService();
        $waitingTimeline1 = new WaitingTimeline(1, 2, 3, 3, 4, ResponseType::P, new DateTime('2023-02-01'), 10);
        $waitingTimeline2 = new WaitingTimeline(1, 2, 2, 3, 5, ResponseType::N, new DateTime('2023-01-01'), 10);

        $waitingTimelineService->addEntity($waitingTimeline1);
        $waitingTimelineService->addEntity($waitingTimeline2);

        $query = new Query(1, 2, 3, 3, null, ResponseType::P, new DateTime('2023-01-01'));

        $result = $waitingTimelineService->findEntitiesByQuery($query);

        $this->assertCount(1, $result);
        $this->assertInstanceOf(WaitingTimeline::class, $result[0]);
    }

    public function testFindEntitiesByQueryWithWildCards()
    {
        $waitingTimelineService = new WaitingTimelineService();
        $waitingTimeline1 = new WaitingTimeline(1, 2, 3, 3, 4, ResponseType::P, new DateTime('2023-02-01'), 10);
        $waitingTimeline2 = new WaitingTimeline(1, 2, 2, 7, 5, ResponseType::N, new DateTime('2023-11-01'), 11);
        $waitingTimeline3 = new WaitingTimeline(2, 1, 5, 3, 2, ResponseType::N, new DateTime('2023-10-01'), 2);
        $waitingTimeline4 = new WaitingTimeline(3, 3, 6, 5, 3, ResponseType::N, new DateTime('2023-09-01'), 10);
        $waitingTimeline5 = new WaitingTimeline(4, 5, 4, 1, 7, ResponseType::N, new DateTime('2023-04-01'), 10);

        $waitingTimelineService->addEntity($waitingTimeline1);
        $waitingTimelineService->addEntity($waitingTimeline2);
        $waitingTimelineService->addEntity($waitingTimeline3);
        $waitingTimelineService->addEntity($waitingTimeline4);
        $waitingTimelineService->addEntity($waitingTimeline5);

        $query = new Query(null, null, null, null, null, ResponseType::N, new DateTime('2023-01-01'));

        $result = $waitingTimelineService->findEntitiesByQuery($query);

        $this->assertCount(4, $result);
        $this->assertInstanceOf(WaitingTimeline::class, $result[0]);
        $this->assertInstanceOf(WaitingTimeline::class, $result[1]);
        $this->assertInstanceOf(WaitingTimeline::class, $result[2]);
        $this->assertInstanceOf(WaitingTimeline::class, $result[3]);
    }

    public function testFindEntitiesByQueryWithExactData()
    {
        $waitingTimelineService = new WaitingTimelineService();
        $waitingTimeline1 = new WaitingTimeline(1, 2, 3, 3, 4, ResponseType::P, new DateTime('2023-02-01'), 10);
        $waitingTimeline2 = new WaitingTimeline(1, 2, 2, 7, 5, ResponseType::N, new DateTime('2023-11-01'), 20);
        $waitingTimeline3 = new WaitingTimeline(1, 1, 1, 1, 1, ResponseType::N, new DateTime('2023-10-01'), 40);
        $waitingTimeline4 = new WaitingTimeline(1, 1, 1, 1, 1, ResponseType::N, new DateTime('2023-09-01'), 34);
        $waitingTimeline5 = new WaitingTimeline(1, 1, 1, 1, 1, ResponseType::N, new DateTime('2023-11-01'), 52);

        $waitingTimelineService->addEntity($waitingTimeline1);
        $waitingTimelineService->addEntity($waitingTimeline2);
        $waitingTimelineService->addEntity($waitingTimeline3);
        $waitingTimelineService->addEntity($waitingTimeline4);
        $waitingTimelineService->addEntity($waitingTimeline5);

        $query = new Query(1, 1, 1, 1, 1, ResponseType::N, new DateTime('2023-06-01'), new DateTime('2023-10-01'));

        $result = $waitingTimelineService->findEntitiesByQuery($query);

        $this->assertCount(1, $result);
        $this->assertInstanceOf(WaitingTimeline::class, $result[0]);
    }
}
