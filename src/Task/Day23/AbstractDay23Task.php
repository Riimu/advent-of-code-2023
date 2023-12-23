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
    private const JUNCTION_START = 0;
    private const JUNCTION_END = 1;

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

        return $this->findLongestPath($junctions);
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
     * @return array<int, array<int, array{0: int, 1: int}>>
     */
    private function mapAllJunctions(array $map, int $startX, int $startY, int $endX, int $endY): array
    {
        $junctions = [[], []];
        $junctionMap = [];
        $junctionExits = [];

        $junctionMap[$startY][$startX] = self::JUNCTION_START;
        $junctionMap[$endY][$endX] = self::JUNCTION_END;

        foreach ($this->getPossibleDirections($map, $startX, $startY) as [$x, $y, $direction]) {
            $junctionExits[] = [$x, $y, $direction, self::JUNCTION_START];
        }

        while ($junctionExits !== []) {
            [$x, $y, $direction, $lastJunction] = array_pop($junctionExits);

            $reversible = true;
            $steps = 0;

            while (true) {
                $steps++;

                if (isset($junctionMap[$y][$x])) {
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
                    $newJunction = \count($junctions);
                    $junctionMap[$y][$x] = $newJunction;
                    $junctions[] = [];

                    foreach ($possibleDirections as [$newX, $newY, $newDirection]) {
                        $junctionExits[] = [$newX, $newY, $newDirection, $newJunction];
                    }

                    break;
                }

                [$x, $y, $direction] = $otherDirections[array_key_first($otherDirections)];
            }

            $junctions[$lastJunction][] = [$junctionMap[$y][$x], $steps];

            if ($reversible) {
                $junctions[$junctionMap[$y][$x]][] = [$lastJunction, $steps];
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
     * @param array<int, array<int, array{0: int, 1: int}>> $junctions
     * @return int
     */
    protected function findLongestPath(array $junctions): int
    {
        /** @var array<int, array{0: int, 1: int, 2: array<int, bool>}> $traverseQueue */
        $traverseQueue = [[self::JUNCTION_START, 0, array_fill(0, \count($junctions), false)]];
        $maxLength = 0;

        while ($traverseQueue !== []) {
            [$junction, $steps, $visitedJunctions] = array_pop($traverseQueue);

            if ($junction === self::JUNCTION_END) {
                if ($steps > $maxLength) {
                    $maxLength = $steps;
                }

                continue;
            }

            $visitedJunctions[$junction] = true;

            foreach ($junctions[$junction] as [$nextJunction, $nextSteps]) {
                if ($visitedJunctions[$nextJunction]) {
                    continue;
                }

                $traverseQueue[] = [$nextJunction, $steps + $nextSteps, $visitedJunctions];
            }
        }

        return $maxLength;
    }
}
