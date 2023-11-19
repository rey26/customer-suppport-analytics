<?php

namespace App\Command;

use App\Service\MainService;
use App\Service\WaitingTimelineService;
use Throwable;

class AnalyzeCommand
{
    private const INPUT_FILE = 'var/input.txt';
    private const OUTPUT_FILE = 'var/output.txt';

    private MainService $mainService;

    public function __construct()
    {
        $this->mainService = new MainService(new WaitingTimelineService());
    }

    public function execute(): int
    {
        try {
            echo 'Analyzing customer support data...' . PHP_EOL;
            $inputFile = fopen(self::INPUT_FILE, 'r');
            $output = $this->mainService
                ->parseInput(fread($inputFile, filesize(self::INPUT_FILE)))
                ->handleInput()
                ->getOutput()
            ;

            $fileHandle = fopen(self::OUTPUT_FILE, 'w');
            fwrite($fileHandle, $output);
            fclose($fileHandle);

            echo 'Analyzing finished successfully!' . PHP_EOL;

            return 0;
        } catch (Throwable $t) {
            echo 'An error ocurred: ' . $t->getMessage() . PHP_EOL;
            return 1;
        }
    }
}
