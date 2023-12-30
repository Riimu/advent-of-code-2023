<?php

declare(strict_types=1);

namespace Riimu\AdventOfCode2023\Task\Day18;

use Riimu\AdventOfCode2023\TaskInputInterface;
use Riimu\AdventOfCode2023\TaskInterface;
use Riimu\AdventOfCode2023\Utility\Direction;
use Riimu\AdventOfCode2023\Utility\Parse;

/**
 * @author Riikka Kalliomäki <riikka.kalliomaki@gmail.com>
 * @copyright Copyright (c) 2023 Riikka Kalliomäki
 * @license http://opensource.org/licenses/mit-license.php MIT License
 */
abstract class AbstractDay18Task implements TaskInterface
{
    final public function __construct() {}

    public static function createTask(): static
    {
        return new static();
    }

    public function parseInput(string $input): Day18Input
    {
        $instructions = [];

        foreach (Parse::lines($input) as $line) {
            if (!preg_match('/([RLUD])\s+(\d+)\s+\(#([0-9A-Fa-f]{6})\)/', $line, $match)) {
                throw new \RuntimeException("Unexpected line in input '$line'");
            }

            $instructions[] = new Instruction(
                Direction::fromString($match[1]),
                Parse::int($match[2]),
                Parse::hexadecimal($match[3])
            );
        }

        return new Day18Input($instructions);
    }

    public function solveTask(TaskInputInterface $input): string
    {
        if (!$input instanceof Day18Input) {
            throw new \InvalidArgumentException(sprintf("Unexpected input type '%s'", get_debug_type($input)));
        }

        return (string) $this->solve($input);
    }

    protected function solve(Day18Input $input): int
    {
        $totalLength = 0;
        $points = [];
        $x = 0;
        $y = 0;

        foreach ($input->instructions as $instruction) {
            $direction = $this->getDirection($instruction);
            $distance = $this->getDistance($instruction);
            $totalLength += $distance;
            [$x, $y] = $direction->moveCoordinates($x, $y, $distance);
            $points[] = [$x, $y];
        }

        /** @see https://en.wikipedia.org/wiki/Shoelace_formula */
        $area = 0;
        $count = \count($points);

        foreach ($points as $i => $point) {
            $previous = $i === 0 ? $count - 1 : $i - 1;
            $next = ($i + 1) % $count;
            $area += $point[1] * ($points[$previous][0] - $points[$next][0]);
        }

        $area = abs($area / 2);

        /** @see https://en.wikipedia.org/wiki/Pick%27s_theorem */
        $internalPoints = $area - ($totalLength / 2) + 1;

        return $internalPoints + $totalLength;
    }

    abstract protected function getDirection(Instruction $instruction): Direction;

    abstract protected function getDistance(Instruction $instruction): int;
}
