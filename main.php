<?php

require_once 'vendor/autoload.php';

use App\Command\AnalyzeCommand;

$analyzeCommand = new AnalyzeCommand();

$analyzeCommand->execute();
