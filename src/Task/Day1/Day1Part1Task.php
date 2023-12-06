<?php

declare(strict_types=1);

namespace Riimu\AdventOfCode2023\Task\Day1;

/**
 * @author Riikka Kalliomäki <riikka.kalliomaki@gmail.com>
 * @copyright Copyright (c) 2023 Riikka Kalliomäki
 * @license http://opensource.org/licenses/mit-license.php MIT License
 */
class Day1Part1Task extends AbstractDay1Task
{
    private const DIGITS = [
        '0' => 0,
        '1' => 1,
        '2' => 2,
        '3' => 3,
        '4' => 4,
        '5' => 5,
        '6' => 6,
        '7' => 7,
        '8' => 8,
        '9' => 9,
    ];

    public static function createTask(): static
    {
        return new static(self::DIGITS);
    }
}
