<?php

namespace App\Service\Factory;

use App\Entity\Query;
use App\Enum\ResponseType;
use App\Exception\QueryException;
use App\Service\Validator\InputValidator;
use DateTime;

class QueryFactory
{
    /**
     * @throws QueryException
     */
    public static function createFromInputLine(string $inputLine): Query
    {
        $data = explode(' ', $inputLine);

        if (count($data) !== 4) {
            throw new QueryException('Input line is invalid!');
        }
        $serviceInfo = explode('.', $data[0]);
        InputValidator::validateService($serviceInfo);

        $serviceId = $serviceInfo[0] !== '*' ? (int) $serviceInfo[0] : null;
        $variationId = isset($serviceInfo[1]) && $serviceInfo[1] !== '*' ? (int) $serviceInfo[1] : null;

        // @TODO add validation for question type
        $questionType = explode('.', $data[1]);
        if (count($questionType) > 3) {
            throw new QueryException('Invalid question type information!');
        }
        $questionTypeId = $questionType[0] !== '*' ? (int) $questionType[0] : null;
        $categoryId = isset($questionType[1]) && $questionType[1] !== '*' ? (int) $questionType[1] : null;
        $subCategoryId = isset($questionType[2]) && $questionType[2] !== '*' ? (int) $questionType[2] : null;

        $responseType = ResponseType::from($data[2]);
        $dates = explode('-', $data[3]);

        if (count($dates) > 2) {
            throw new QueryException('Invalid date range!');
        }
        $dateFrom = DateTime::createFromFormat('d.m.Y', $dates[0]);

        if ($dateFrom === false) {
            throw new QueryException('Invalid date format for Date From: ' . $dates[0]);
        }
        $dateTo = null;

        if (count($dates) === 2) {
            if ($dates[1] === '*') {
                $dateTo = null;
            } else {
                $dateTo = DateTime::createFromFormat('d.m.Y', $dates[1]);
                if ($dateTo === false) {
                    throw new QueryException('Invalid date format for Date To: ' . $dates[1]);
                }
            }
        }

        return new Query(
            $serviceId,
            $variationId,
            $questionTypeId,
            $categoryId,
            $subCategoryId,
            $responseType,
            $dateFrom,
            $dateTo
        );
    }
}
