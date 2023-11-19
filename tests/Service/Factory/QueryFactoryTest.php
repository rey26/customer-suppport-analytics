<?php

namespace App\Tests\Service\Factory;

use PHPUnit\Framework\TestCase;
use App\Service\Factory\QueryFactory;
use App\Entity\Query;
use App\Enum\ResponseType;
use App\Exception\QueryException;
use DateTime;

class QueryFactoryTest extends TestCase
{
    public function testCreateFromValidInputLine()
    {
        $inputLine = '1.2 3.4.5 N 01.01.2023-10.01.2023';
        $query = QueryFactory::createFromInputLine($inputLine);

        $this->assertInstanceOf(Query::class, $query);
        $this->assertEquals(1, $query->getServiceId());
        $this->assertEquals(2, $query->getVariationId());
        $this->assertEquals(3, $query->getQuestionTypeId());
        $this->assertEquals(4, $query->getCategoryId());
        $this->assertEquals(5, $query->getSubCategoryId());
        $this->assertEquals(ResponseType::N, $query->getResponseType());
        $this->assertInstanceOf(DateTime::class, $query->getDateFrom());
        $this->assertInstanceOf(DateTime::class, $query->getDateTo());
    }

    public function testCreateFromNullValuesInInputLine()
    {
        $inputLine = '1.* 3.4.* P 01.01.2023-*';
        $query = QueryFactory::createFromInputLine($inputLine);

        $this->assertInstanceOf(Query::class, $query);
        $this->assertEquals(1, $query->getServiceId());
        $this->assertNull($query->getVariationId());
        $this->assertEquals(3, $query->getQuestionTypeId());
        $this->assertEquals(4, $query->getCategoryId());
        $this->assertNull($query->getSubCategoryId());
        $this->assertEquals(ResponseType::P, $query->getResponseType());
        $this->assertInstanceOf(DateTime::class, $query->getDateFrom());
        $this->assertNull($query->getDateTo());
    }

    public function testCreateFromWithManyNullValuesInInputLine()
    {
        $inputLine = '* * P 01.01.2023-*';
        $query = QueryFactory::createFromInputLine($inputLine);

        $this->assertInstanceOf(Query::class, $query);
        $this->assertNull($query->getServiceId());
        $this->assertNull($query->getVariationId());
        $this->assertNull($query->getQuestionTypeId());
        $this->assertNull($query->getCategoryId());
        $this->assertNull($query->getSubCategoryId());
        $this->assertEquals(ResponseType::P, $query->getResponseType());
        $this->assertInstanceOf(DateTime::class, $query->getDateFrom());
        $this->assertNull($query->getDateTo());
    }

    public function testCreateFromInvalidInputLine()
    {
        $this->expectException(QueryException::class);

        $inputLine = 'Invalid input line';
        QueryFactory::createFromInputLine($inputLine);
    }

    public function testCreateFromInvalidDateFormat()
    {
        $this->expectException(QueryException::class);

        $inputLine = '1.2 3.4.5 P 01-01-2023-10.01.2023'; // Invalid date format
        QueryFactory::createFromInputLine($inputLine);
    }
}
