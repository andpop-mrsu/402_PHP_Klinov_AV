<?php

declare(strict_types=1);

namespace NevallvonGoodem\Task02\Gcd;

function gcd(int $a, int $b): int
{
    $a = abs($a);
    $b = abs($b);

    while ($b !== 0) {
        [$a, $b] = [$b, $a % $b];
    }

    return $a;
}

function makeNumbers(int $min = 1, int $max = 100): array
{
    return [random_int($min, $max), random_int($min, $max)];
}