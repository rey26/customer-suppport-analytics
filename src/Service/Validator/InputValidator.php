<?php

namespace App\Service\Validator;

use InvalidArgumentException;

class InputValidator
{
    /**
     * @throws InvalidArgumentException
     */
    public static function validateService(array $serviceData): void
    {
        if (count($serviceData) > 2 && $serviceData[0] !== '*') {
            throw new InvalidArgumentException('Service Information is invalid!');
        }

        if ($serviceData[0] !== '*' && ($serviceData[0] < 1 || $serviceData[0] > 10)) {
            throw new InvalidArgumentException('Service out of range: ' . $serviceData[0]);
        }

        if (isset($serviceData[1]) && $serviceData[1] !== '*' && ($serviceData[1] < 1 || $serviceData[1] > 3)) {
            throw new InvalidArgumentException('Service variant out of range: ' . $serviceData[1]);
        }
    }
}
