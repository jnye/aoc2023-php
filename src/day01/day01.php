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

function convertWordsToDigits(string $line): string
{
    $map = [
        'one' => '1',
        'two' => '2',
        'three' => '3',
        'four' => '4',
        'five' => '5',
        'six' => '6',
        'seven' => '7',
        'eight' => '8',
        'nine' => '9',
    ];
    $result = '';
    for ($i = 0; $i < strlen($line); $i++) {
        $substr = substr($line, $i);
        $firstCharacter = $substr[0];
        if (ctype_digit($firstCharacter)) {
            $result .= $firstCharacter;
            continue;
        }
        $foundWord = false;
        foreach ($map as $word => $number) {
            if (str_starts_with($substr, $word)) {
                $result .= $number;
                $foundWord = true;
                break;
            }
        }
        if (!$foundWord) {
            $result .= $firstCharacter;
        }
    }
    return $result;
}

$lines = new Collection(file('input.txt', FILE_IGNORE_NEW_LINES));
$calibrationValues = $lines
    ->map(fn($line) => convertWordsToDigits($line))
    ->map(fn($line) => recoverCalibrationValue($line));

print "Answer 2: " . $calibrationValues->sum() . PHP_EOL;
