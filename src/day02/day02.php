<?php

require_once __DIR__ . '/../../vendor/autoload.php';

use Illuminate\Support\Collection;

const MAX_RED = 12;
const MAX_GREEN = 13;
const MAX_BLUE = 14;

$lines = new Collection(file('input.txt', FILE_IGNORE_NEW_LINES));

$answer1 = $lines->map(function ($line) {
    if (!preg_match('/^Game (\d+):\s*(.*?)$/', $line, $matches)) {
        return null;
    }
    $gameId = (int)$matches[1];
    $reveals = (new Collection(preg_split('/;\s*/', $matches[2])))->map(function ($phrase) {
        $red = $green = $blue = 0;
        if (preg_match('/(\d+) red/', $phrase, $matches)) $red = (int)$matches[1];
        if (preg_match('/(\d+) green/', $phrase, $matches)) $green = (int)$matches[1];
        if (preg_match('/(\d+) blue/', $phrase, $matches)) $blue = (int)$matches[1];
        return [$red, $green, $blue];
    });
    return [
        'gameId' => $gameId,
        'reveals' => $reveals,
    ];
})->filter(function ($data) {
    $over_max = false;
    foreach ($data['reveals'] as $counts) {
        if ($counts[0] > MAX_RED || $counts[1] > MAX_GREEN || $counts[2] > MAX_BLUE) {
            $over_max = true;
            break;
        }
    }
    return !$over_max;
})->sum(function ($data) {
    return $data['gameId'];
});

print "Answer 1: $answer1\n";
