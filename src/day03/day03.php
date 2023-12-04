<?php

require_once __DIR__ . '/../../vendor/autoload.php';

use Illuminate\Support\Collection;

$lines = new Collection(file('input.txt', FILE_IGNORE_NEW_LINES));

$schematic = [];
$symbolMask = [];
$data = $lines->each(function ($line, $number) use (&$schematic, &$symbolMask) {
    $schematic[$number] = $line;
    $symbolMask[$number] = str_repeat('0', strlen($line));
});

$height = count($schematic);
$width = strlen($schematic[0]);
for ($y = 0; $y < $height; $y++) {
    for ($x = 0; $x < $width; $x++) {
        if (!preg_match('/\d|\\./', $schematic[$y][$x])) {
            for ($ys = max(0, $y - 1); $ys <= min($height - 1, $y + 1); $ys++) {
                for ($xs = max(0, $x - 1); $xs <= min($width - 1, $x + 1); $xs++) {
                    $symbolMask[$ys][$xs] = '1';
                }
            }
        };
    }
}

$answer1 = 0;
for ($y = 0; $y < $height; $y++) {
    for ($x = 0; $x < $width; $x++) {
        if (ctype_digit($schematic[$y][$x])) {
            $start = $end = $x;
            while (ctype_digit(@$schematic[$y][$end + 1])) {
                $end += 1;
            }
            $x = $end;
            for ($i = $start; $i <= $end; $i++) {
                if ($symbolMask[$y][$i] == '1') {
                    $answer1 += (int)substr($schematic[$y], $start, $end - $start + 1);
                    break;
                }
            }
        }
    }
}

print "Answer 1: $answer1\n";
