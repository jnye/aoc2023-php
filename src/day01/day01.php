<?php

require_once __DIR__ . '/../../vendor/autoload.php';

use Illuminate\Support\Collection;

function recoverCalibrationValue(string $line): string
{
    $digits = (new Collection(str_split($line)))
        ->filter(fn($character) => ctype_digit($character));
    return $digits->first() . $digits->last();
}

$lines = new Collection(file('input.txt', FILE_IGNORE_NEW_LINES));
$calibrationValues = $lines->map(fn($line) => recoverCalibrationValue($line));

print "Answer 1: " . $calibrationValues->sum() . PHP_EOL;
