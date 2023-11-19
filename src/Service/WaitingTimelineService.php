<?php

namespace App\Service;

use App\Entity\Query;
use App\Entity\WaitingTimeline;

class WaitingTimelineService
{
    /** @var WaitingTimeline[] */
    protected array $entities = [];

    /** @var WaitingTimeline[] */
    protected array $matchingEntities = [];

    public function addEntity(WaitingTimeline $waitingTimeline): static
    {
        $this->entities[] = $waitingTimeline;

        return $this;
    }

    public function resetEntities(): static
    {
        $this->entities = [];
        $this->matchingEntities = [];

        return $this;
    }

    public function setMatchingEntitiesByQuery(Query $query): static
    {
        $this->matchingEntities = [];

        foreach ($this->entities as $waitingTimeline) {
            $matchingWaitingTimeline = $this->checkForMatch($waitingTimeline, $query);

            if ($matchingWaitingTimeline !== null) {
                $this->matchingEntities[] = $matchingWaitingTimeline;
            }
        }

        return $this;
    }

    public function getMatchingEntities(): array
    {
        return $this->matchingEntities;
    }

    public function getAverageWaitingTime(): ?int
    {
        if (empty($this->matchingEntities)) {
            return null;
        }
        $count = 0;
        $totalWaitingTime = 0;

        foreach ($this->matchingEntities as $matchingEntity) {
            $totalWaitingTime += $matchingEntity->getWaitingTimeMinutes();
            $count++;
        }

        return round($totalWaitingTime / $count);
    }

    private function checkForMatch(WaitingTimeline $wt, Query $query): ?WaitingTimeline
    {
        if ($query->getServiceId() !== null && $wt->getServiceId() !== $query->getServiceId()) {
            return null;
        }

        if ($query->getVariationId() !== null && $wt->getVariationId() !== $query->getVariationId()) {
            return null;
        }

        if ($query->getQuestionTypeId() !== null && $wt->getQuestionTypeId() !== $query->getQuestionTypeId()) {
            return null;
        }

        if ($query->getCategoryId() !== null && $wt->getCategoryId() !== $query->getCategoryId()) {
            return null;
        }

        if ($query->getSubCategoryId() !== null && $wt->getSubCategoryId() !== $query->getSubCategoryId()) {
            return null;
        }

        if ($query->getResponseType() !== $wt->getResponseType()) {
            return null;
        }

        if ($query->getDateFrom() >= $wt->getResponseDate()) {
            return null;
        }

        if ($query->getDateTo() !== null && $query->getDateTo() <= $wt->getResponseDate()) {
            return null;
        }

        return $wt;
    }
}
