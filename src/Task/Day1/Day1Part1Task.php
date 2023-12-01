<?php

declare(strict_types=1);

namespace Riimu\AdventOfCode2023\Task\Day1;

use Riimu\AdventOfCode2023\TaskInputInterface as T;
use Riimu\AdventOfCode2023\TaskInterface;

/**
 * @author Riikka Kalliomäki <riikka.kalliomaki@gmail.com>
 * @copyright Copyright (c) 2023 Riikka Kalliomäki
 * @license http://opensource.org/licenses/mit-license.php MIT License
 * @implements TaskInterface<Day1Input>
 */
class Day1Part1Task implements TaskInterface
{
    private const DIGITS = '0123456789';

    public static function createTask(): static
    {
        return new self();
    }

    public function solveTask(T $input): string
    {
        $calibrationValues = [];

        foreach ($input->lines as $line) {
            $firstDigit = $line[strcspn($line, self::DIGITS)];
            $lastDigit = $line[-strcspn(strrev($line), self::DIGITS) - 1];

            $calibrationValues[] = $firstDigit === '0'
                ? (int) $lastDigit
                : (int) ($firstDigit . $lastDigit);
        }

        return (string) array_sum($calibrationValues);
    }

    public function parseInput(string $input): T
    {
        return new Day1Input(preg_split('/[\r\n]+/', trim($input)));
    }

}
