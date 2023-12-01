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
class Day1Part2Task implements TaskInterface
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
        'one' => 1,
        'two' => 2,
        'three' => 3,
        'four' => 4,
        'five' => 5,
        'six' => 6,
        'seven' => 7,
        'eight' => 8,
        'nine' => 9,
    ];

    public static function createTask(): static
    {
        return new self();
    }

    public function solveTask(T $input): string
    {
        $calibrationValues = [];

        foreach ($input->lines as $line) {
            $firstDigit = $this->findFirstDigit($line);
            $lastDigit = $this->findLastDigit($line);

            $calibrationValues[] = $firstDigit === 0
                ? $lastDigit
                : $firstDigit * 10 + $lastDigit;
        }

        return (string) array_sum($calibrationValues);
    }

    public function findFirstDigit(string $line): int
    {
        static $pattern;

        $pattern ??= sprintf('/%s/', implode('|', array_map(
            static fn (string $x): string => preg_quote($x, '/'),
            array_keys(self::DIGITS)
        )));

        preg_match($pattern, $line, $match);

        return self::DIGITS[$match[0]];
    }

    public function findLastDigit(string $line): int
    {
        static $pattern;

        $pattern ??= sprintf('/.*(%s)/', implode('|', array_map(
            static fn (string $x): string => preg_quote($x, '/'),
            array_keys(self::DIGITS)
        )));

        preg_match($pattern, $line, $match);

        return self::DIGITS[$match[1]];
    }

    public function parseInput(string $input): T
    {
        return new Day1Input(preg_split('/[\r\n]+/', trim($input)));
    }

}
