<?php

namespace App\Tests\Entity;

use PHPUnit\Framework\TestCase;
use App\Entity\Query;
use App\Enum\ResponseType;
use DateTime;
use DateTimeInterface;

class QueryTest extends TestCase
{
    public function testQueryEntityWithNonNullValues()
    {
        $serviceId = 1;
        $variationId = 2;
        $questionTypeId = 3;
        $categoryId = 4;
        $subCategoryId = 5;
        $responseType = ResponseType::P;
        $dateFrom = new DateTime('2022-01-01');
        $dateTo = new DateTime('2022-01-10');

        $query = new Query(
            $serviceId,
            $variationId,
            $questionTypeId,
            $categoryId,
            $subCategoryId,
            $responseType,
            $dateFrom,
            $dateTo
        );

        // Assertions for getters with non-null values
        $this->assertEquals($serviceId, $query->getServiceId());
        $this->assertEquals($variationId, $query->getVariationId());
        $this->assertEquals($questionTypeId, $query->getQuestionTypeId());
        $this->assertEquals($categoryId, $query->getCategoryId());
        $this->assertEquals($subCategoryId, $query->getSubCategoryId());
        $this->assertEquals($responseType, $query->getResponseType());
        $this->assertInstanceOf(DateTimeInterface::class, $query->getDateFrom());
        $this->assertInstanceOf(DateTimeInterface::class, $query->getDateTo());
    }

    public function testQueryEntityWithNullValues()
    {
        $responseType = ResponseType::N;
        $dateFrom = new DateTime('2022-01-01');

        $query = new Query(
            null,
            null,
            null,
            null,
            null,
            $responseType,
            $dateFrom,
            null
        );

        // Assertions for getters with null values
        $this->assertNull($query->getServiceId());
        $this->assertNull($query->getVariationId());
        $this->assertNull($query->getQuestionTypeId());
        $this->assertNull($query->getCategoryId());
        $this->assertNull($query->getSubCategoryId());
        $this->assertEquals($responseType, $query->getResponseType());
        $this->assertInstanceOf(DateTimeInterface::class, $query->getDateFrom());
        $this->assertNull($query->getDateTo());
    }
}
