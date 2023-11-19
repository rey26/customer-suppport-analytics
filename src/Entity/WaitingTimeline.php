<?php

namespace App\Entity;

use App\Enum\ResponseType;

class WaitingTimeline
{
    public function __construct(
        private int $serviceId,
        private ?int $variationId,
        private string $questionTypeId,
        private ?int $categoryId,
        private ?int $subCategoryId,
        private ResponseType $responseType,
        private string $responseDate,
        private int $waitingTimeMinutes
    ) {
    }

    public function getServiceId(): int
    {
        return $this->serviceId;
    }

    public function getVariationId(): ?int
    {
        return $this->variationId;
    }

    public function getQuestionTypeId(): string
    {
        return $this->questionTypeId;
    }

    public function getCategoryId(): ?int
    {
        return $this->categoryId;
    }

    public function getSubCategoryId(): ?int
    {
        return $this->subCategoryId;
    }

    public function getResponseType(): ResponseType
    {
        return $this->responseType;
    }

    public function getResponseDate(): string
    {
        return $this->responseDate;
    }

    public function getWaitingTimeMinutes(): int
    {
        return $this->waitingTimeMinutes;
    }
}
