<?php

declare(strict_types=1);

namespace Riimu\AdventOfCode2023\Task\Day23;

use Riimu\AdventOfCode2023\TaskInputInterface;
use Riimu\AdventOfCode2023\TaskInterface;
use Riimu\AdventOfCode2023\Utility\Direction;
use Riimu\AdventOfCode2023\Utility\Parse;

/**
 * @author Riikka Kalliomäki <riikka.kalliomaki@gmail.com>
 * @copyright Copyright (c) 2023 Riikka Kalliomäki
 * @license http://opensource.org/licenses/mit-license.php MIT License
 */
abstract class AbstractDay23Task implements TaskInterface
{
    final public function __construct() {}

    public static function createTask(): static
    {
        return new static();
    }

    public function parseInput(string $input): Day23Input
    {
        return new Day23Input(array_map(str_split(...), Parse::lines($input)));
    }

    public function solveTask(TaskInputInterface $input): string
    {
        if (!$input instanceof Day23Input) {
            throw new \InvalidArgumentException(sprintf("Unexpected input type '%s'", get_debug_type($input)));
        }

        return (string) $this->solve($input);
    }

    protected function solve(Day23Input $input): int
    {
        $startY = 0;
        $startX = $this->findSymbolInRow($input->map, $startY, Day23Input::NODE_SPACE);
        $endY = \count($input->map) - 1;
        $endX = $this->findSymbolInRow($input->map, $endY, Day23Input::NODE_SPACE);
        $junctions = $this->mapAllJunctions($input->map, $startX, $startY, $endX, $endY);

        return $this->findLongestPath($junctions, $startX, $startY, $endX, $endY);
    }

    /**
     * @param array<int, array<int, string>> $map
     * @param int $row
     * @param string $symbol
     * @return int
     */
    private function findSymbolInRow(array $map, int $row, string $symbol): int
    {
        foreach ($map[$row] as $x => $node) {
            if ($node === $symbol) {
                return $x;
            }
        }

        return 0;
    }

    /**
     * @param array<int, array<int, string>> $map
     * @param int $startX
     * @param int $startY
     * @param int $endX
     * @param int $endY
     * @return array<int, array<int, array<int, array{0: int, 1: int, 2: int}>>>
     */
    private function mapAllJunctions(array $map, int $startX, int $startY, int $endX, int $endY): array
    {
        $junctions = [$startY => [$startX => []], $endY => [$endX => []]];
        $junctionExits = [];

        foreach ($this->getPossibleDirections($map, $startX, $startY) as [$x, $y, $direction]) {
            $junctionExits[] = [$x, $y, $direction, $startX, $startY];
        }

        while ($junctionExits !== []) {
            [$x, $y, $direction, $lastX, $lastY] = array_pop($junctionExits);

            $reversible = true;
            $steps = 0;

            while (true) {
                $steps++;

                if (isset($junctions[$y][$x])) {
                    break;
                }

                $possibleDirections = $this->getPossibleDirections($map, $x, $y);
                $otherDirections = array_diff_key($possibleDirections, [$direction->turnAround()->value => true]);

                if ($otherDirections === []) {
                    continue 2;
                }

                if ($possibleDirections === $otherDirections) {
                    $reversible = false;
                }

                if (\count($otherDirections) > 1) {
                    $junctions[$y][$x] = [];

                    foreach ($possibleDirections as [$newX, $newY, $newDirection]) {
                        $junctionExits[] = [$newX, $newY, $newDirection, $x, $y];
                    }

                    break;
                }

                [$x, $y, $direction] = $otherDirections[array_key_first($otherDirections)];
            }

            $junctions[$lastY][$lastX][] = [$x, $y, $steps];

            if ($reversible) {
                $junctions[$y][$x][] = [$lastX, $lastY, $steps];
                [$exitX, $exitY] = $direction->turnAround()->moveCoordinates($x, $y);

                foreach ($junctionExits as $key => $exit) {
                    if ($exit[0] === $exitX && $exit[1] === $exitY) {
                        array_splice($junctionExits, $key, 1);
                        break;
                    }
                }
            }
        }

        return $junctions;
    }

    /**
     * @param array<int, array<int, string>> $map
     * @param int $x
     * @param int $y
     * @return array<int, array{0: int, 1: int, 2: Direction}>
     */
    private function getPossibleDirections(array $map, int $x, int $y): array
    {
        $directions = [];

        foreach (Direction::cases() as $direction) {
            [$newX, $newY] = $direction->moveCoordinates($x, $y);

            if ($this->isValidDirection($map, $newX, $newY, $direction)) {
                $directions[$direction->value] = [$newX, $newY, $direction];
            }
        }

        return $directions;
    }

    /**
     * @param array<int, array<int, string>> $map
     * @param int $x
     * @param int $y
     * @param Direction $direction
     * @return bool
     */
    abstract protected function isValidDirection(array $map, int $x, int $y, Direction $direction): bool;

    /**
     * @param array<int, array<int, array<int, array{0: int, 1: int, 2: int}>>> $junctions
     * @param int $startX
     * @param int $startY
     * @param int $endX
     * @param int $endY
     * @return int
     */
    protected function findLongestPath(array $junctions, int $startX, int $startY, int $endX, int $endY): int
    {
        $maxLength = 0;
        $traverseQueue = [[$startX, $startY, 0, []]];

        while ($traverseQueue !== []) {
            [$x, $y, $steps, $visitedJunctions] = array_pop($traverseQueue);

            if ($x === $endX && $y === $endY) {
                if ($steps > $maxLength) {
                    $maxLength = $steps;
                }

                continue;
            }

            $visitedJunctions[$y][$x] = true;

            foreach ($junctions[$y][$x] as [$nextX, $nextY, $nextSteps]) {
                if (isset($visitedJunctions[$nextY][$nextX])) {
                    continue;
                }

                $traverseQueue[] = [$nextX, $nextY, $steps + $nextSteps, $visitedJunctions];
            }
        }

        return $maxLength;
    }
}
