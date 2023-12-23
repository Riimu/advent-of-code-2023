<?php

declare(strict_types=1);

namespace Riimu\AdventOfCode2023\Task\Day23;

use Riimu\AdventOfCode2023\Utility\Direction;

/**
 * @author Riikka Kalliomäki <riikka.kalliomaki@gmail.com>
 * @copyright Copyright (c) 2023 Riikka Kalliomäki
 * @license http://opensource.org/licenses/mit-license.php MIT License
 */
class Day23Part2Task extends AbstractDay23Task
{
    protected function solve(Day23Input $input): int
    {
        $startX = 0;
        $startY = 0;
        $endX = 0;
        $endY = \count($input->map) - 1;

        foreach ($input->map[$startY] as $x => $node) {
            if ($node === Day23Input::NODE_SPACE) {
                $startX = $x;
                break;
            }
        }

        foreach ($input->map[$endY] as $x => $node) {
            if ($node === Day23Input::NODE_SPACE) {
                $endX = $x;
                break;
            }
        }

        $junctions = [$startY => [$startX => []], $endY => [$endX => []]];
        $junctionExits = [];

        foreach ($this->getPossibleDirections($input->map, $startX, $startY) as [$x, $y, $direction]) {
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

                $possibleDirections = $this->getPossibleDirections($input->map, $x, $y);
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

        $maxLength = 0;
        $traverseQueue = [[$startX, $startY, 0, []]];

        while ($traverseQueue !== []) {
            [$x, $y, $steps, $visitedJunctions] = array_pop($traverseQueue);

            if ($x === $endX && $y === $endY) {
                $maxLength = max($steps, $maxLength);
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
    private function isValidDirection(array $map, int $x, int $y, Direction $direction): bool
    {
        return isset($map[$y][$x]) && $map[$y][$x] !== Day23Input::NODE_WALL;
    }
}
