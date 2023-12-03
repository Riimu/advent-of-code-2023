<?php

declare(strict_types=1);

namespace Riimu\AdventOfCode2023\Task\Day3;

use Riimu\AdventOfCode2023\TaskInputInterface;
use Riimu\AdventOfCode2023\TaskInterface;

/**
 * @author Riikka Kalliomäki <riikka.kalliomaki@gmail.com>
 * @copyright Copyright (c) 2023 Riikka Kalliomäki
 * @license http://opensource.org/licenses/mit-license.php MIT License
 * @implements TaskInterface<Day3Input>
 */
class Day3Part2Task implements TaskInterface
{
    public static function createTask(): static
    {
        return new self();
    }

    public function parseInput(string $input): TaskInputInterface
    {
        $lines = preg_split('/[\r\n]+/', trim($input));
        $map = [];

        foreach ($lines as $line) {
            $map[] = str_split($line);
        }

        return new Day3Input($map);
    }

    public function solveTask(TaskInputInterface $input): string
    {
        $partNumbers = [];

        foreach ($input->map as $y => $row) {
            foreach ($row as $x => $character) {
                $number = $this->getNumberAt($input, $x, $y);

                if ($number === null) {
                    continue;
                }

                $symbol = $this->getSymbol($input, $number, $x, $y);

                if ($symbol !== null) {
                    $partNumbers[vsprintf('%s-%s-%s', $symbol)][] = $number;
                }
            }
        }

        $gearRatios = [];

        foreach ($partNumbers as $key => $numbers) {
            if ($key[0] === '*' && \count($numbers) === 2) {
                $gearRatios[] = array_product($numbers);
            }
        }

        return (string) array_sum($gearRatios);
    }

    private function getNumberAt(Day3Input $input, int $x, int $y): ?int
    {
        if (!$this->isDigitAt($input, $x, $y) || $this->isDigitAt($input, $x - 1, $y)) {
            return null;
        }

        $digits = [$input->map[$y][$x]];

        for ($i = $x + 1; $this->isDigitAt($input, $i, $y); $i++) {
            $digits[] = $input->map[$y][$i];
        }

        return (int) implode('', $digits);
    }

    private function isDigitAt(Day3Input $input, int $x, int $y): bool
    {
        return isset($input->map[$y][$x]) &&
            \in_array($input->map[$y][$x], ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'], true);
    }

    private function getSymbol(Day3Input $input, int $number, int $x, int $y): ?array
    {
        $maxX = $x + \strlen((string)$number);
        $maxY = $y + 1;

        for ($i = $y - 1; $i <= $maxY; $i++) {
            if (!isset($input->map[$i])) {
                continue;
            }

            for ($j = $x - 1; $j <= $maxX; $j++) {
                if ($this->isSymbolAt($input, $j, $i)) {
                    return [$input->map[$i][$j], $j, $i];
                }
            }
        }

        return null;
    }

    private function isSymbolAt(Day3Input $input, $x, $y): bool
    {
        return isset($input->map[$y][$x]) && !$this->isDigitAt($input, $x, $y) && $input->map[$y][$x] !== '.';
    }

}
