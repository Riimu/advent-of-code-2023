<?php

declare(strict_types=1);

namespace Riimu\AdventOfCode2023\Task\Day3;

use Riimu\AdventOfCode2023\Parse;
use Riimu\AdventOfCode2023\TaskInputInterface;
use Riimu\AdventOfCode2023\TaskInterface;

/**
 * @author Riikka Kalliomäki <riikka.kalliomaki@gmail.com>
 * @copyright Copyright (c) 2023 Riikka Kalliomäki
 * @license http://opensource.org/licenses/mit-license.php MIT License
 */
abstract class AbstractDay3Task implements TaskInterface
{
    final public function __construct() {}

    public static function createTask(): static
    {
        return new static();
    }

    public function parseInput(string $input): Day3Input
    {
        $lines = Parse::lines($input);
        $map = [];

        foreach ($lines as $line) {
            $map[] = str_split($line);
        }

        return new Day3Input($map);
    }

    public function solveTask(TaskInputInterface $input): string
    {
        if (!$input instanceof Day3Input) {
            throw new \InvalidArgumentException(sprintf("Unexpected input type '%s'", get_debug_type($input)));
        }

        return (string) $this->solve($input);
    }

    abstract protected function solve(Day3Input $input): int;

    protected function getNumberAt(Day3Input $input, int $x, int $y): ?int
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

    protected function isDigitAt(Day3Input $input, int $x, int $y): bool
    {
        return isset($input->map[$y][$x]) &&
            \in_array($input->map[$y][$x], ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'], true);
    }

    protected function getSymbolAt(Day3Input $input, int $number, int $x, int $y): ?string
    {
        $maxX = $x + \strlen((string) $number);
        $maxY = $y + 1;

        for ($i = $y - 1; $i <= $maxY; $i++) {
            if (!isset($input->map[$i])) {
                continue;
            }

            for ($j = $x - 1; $j <= $maxX; $j++) {
                if ($this->isSymbolAt($input, $j, $i)) {
                    return sprintf('%s-%d-%d', $input->map[$i][$j], $j, $i);
                }
            }
        }

        return null;
    }

    protected function isSymbolAt(Day3Input $input, int $x, int $y): bool
    {
        return isset($input->map[$y][$x]) && !$this->isDigitAt($input, $x, $y) && $input->map[$y][$x] !== '.';
    }
}
