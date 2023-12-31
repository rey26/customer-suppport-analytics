<?php

namespace App\Entity;

use App\Enum\ResponseType;
use DateTimeInterface;

class Query
{
    public function __construct(
        private ?int $serviceId,
        private ?int $variationId,
        private ?int $questionTypeId,
        private ?int $categoryId,
        private ?int $subCategoryId,
        private ResponseType $responseType,
        private DateTimeInterface $dateFrom,
        private ?DateTimeInterface $dateTo = null,
    ) {
    }

    public function getServiceId(): ?int
    {
        return $this->serviceId;
    }

    public function getVariationId(): ?int
    {
        return $this->variationId;
    }

    public function getQuestionTypeId(): ?int
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

    public function getDateFrom(): DateTimeInterface
    {
        return $this->dateFrom;
    }

    public function getDateTo(): ?DateTimeInterface
    {
        return $this->dateTo;
    }
}
