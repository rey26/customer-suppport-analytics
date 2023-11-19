<?php

namespace App\Service\Factory;

use App\Entity\WaitingTimeline;
use App\Enum\ResponseType;
use App\Exception\WaitingTimelineException;

class WaitingTimelineFactory
{
    public static function createFromInputLine(string $inputLine): WaitingTimeline
    {
        $data = explode(' ', $inputLine);

        if (count($data) !== 5) {
            throw new WaitingTimelineException('Input line is invalid!');
        }

        $serviceInfo = explode('.', $data[0]);
        $serviceId = (int) $serviceInfo[0];
        $variationId = isset($serviceInfo[1]) ? (int) $serviceInfo[1] : null;

        $questionTypeInfo = explode('.', $data[1]);
        $questionTypeId = $questionTypeInfo[0];
        $categoryId = isset($questionTypeInfo[1]) ? (int) $questionTypeInfo[1] : null;
        $subCategoryId = isset($questionTypeInfo[2]) ? (int) $questionTypeInfo[2] : null;

        $responseType = ResponseType::from($data[2]);

        $responseDate = $data[3];

        $waitingTimeMinutes = (int) $data[4];

        return new WaitingTimeline(
            $serviceId,
            $variationId,
            $questionTypeId,
            $categoryId,
            $subCategoryId,
            $responseType,
            $responseDate,
            $waitingTimeMinutes
        );
    }
}
