<?php

namespace App\Service;

use App\Service\Factory\QueryFactory;
use App\Service\Factory\WaitingTimelineFactory;
use InvalidArgumentException;

class MainService
{
    private array $parsedInput = [];

    private array $output = [];

    public function __construct(protected WaitingTimelineService $waitingTimelineService)
    {
    }

    /** @throws InvalidArgumentException */
    public function parseInput(string $input): static
    {
        $parsedInput = array_filter(explode(PHP_EOL, $input));

        if (empty($parsedInput) || (count($parsedInput) - 1) !== (int) $parsedInput[0] || $parsedInput[0] > 100000) {
            throw new InvalidArgumentException('Input is invalid!');
        }
        array_shift($parsedInput);

        $this->parsedInput = array_map('trim', $parsedInput);
        $this->output = [];

        return $this;
    }

    public function getParsedInput(): array
    {
        return $this->parsedInput;
    }

    /** @throws InvalidArgumentException */
    public function handleInput(): static
    {
        $this->waitingTimelineService->resetEntities();

        foreach ($this->parsedInput as $input) {
            $queryLineType = substr($input, 0, 1);

            if ($queryLineType === 'C') {
                $this->waitingTimelineService->addEntity(
                    WaitingTimelineFactory::createFromInputLine(trim(substr($input, 1)))
                );
            } elseif ($queryLineType === 'D') {
                $query = QueryFactory::createFromInputLine(trim(substr($input, 1)));

                $averageWaitingTime = $this->waitingTimelineService
                    ->setMatchingEntitiesByQuery($query)
                    ->getAverageWaitingTime()
                ;

                if ($averageWaitingTime === null) {
                    $this->output[] = '-';
                } else {
                    $this->output[] = $averageWaitingTime;
                }
            } else {
                throw new InvalidArgumentException('Invalid type of QueryLine: ' . $queryLineType);
            }
        }

        return $this;
    }

    public function getOutput(): string
    {
        return implode(PHP_EOL, $this->output);
    }
}
