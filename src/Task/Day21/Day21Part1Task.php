<?php

declare(strict_types=1);

namespace Riimu\AdventOfCode2023\Task\Day21;

use Riimu\AdventOfCode2023\Utility\Direction;

/**
 * @author Riikka Kalliomäki <riikka.kalliomaki@gmail.com>
 * @copyright Copyright (c) 2023 Riikka Kalliomäki
 * @license http://opensource.org/licenses/mit-license.php MIT License
 */
class Day21Part1Task extends AbstractDay21Task
{
    private const MAX_STEPS = 64;

    protected function solve(Day21Input $input): int
    {
        $visitedNodes = [];
        [$startX, $startY] = $this->findSymbol($input->map, Day21Input::NODE_START);

        /** @var \SplQueue<array{0: int, 1: int, 2: int}> $stepsQueue */
        $stepsQueue = new \SplQueue();
        $stepsQueue->enqueue([$startX, $startY, 0]);

        while (!$stepsQueue->isEmpty()) {
            [$x, $y, $steps] = $stepsQueue->dequeue();
            $steps++;

            foreach (Direction::cases() as $direction) {
                [$newX, $newY] = $direction->moveCoordinates($x, $y);

                if (isset($input->map[$newY][$newX]) && $input->map[$newY][$newX] !== Day21Input::NODE_WALL && !isset($visitedNodes[$newY][$newX])) {
                    $visitedNodes[$newY][$newX] = true;

                    if ($steps < self::MAX_STEPS) {
                        $stepsQueue->enqueue([$newX, $newY, $steps]);
                    }
                }
            }
        }

        $totalReachable = 0;

        foreach ($visitedNodes as $y => $row) {
            foreach ($row as $x => $node) {
                if ((abs($startX - $x) + abs($startY - $y)) % 2 === 0) {
                    $totalReachable++;
                }
            }
        }

        return $totalReachable;
    }

    /**
     * @param array<int, array<int, string>> $map
     * @param string $symbol
     * @return array{0: int, 1: int}
     */
    private function findSymbol(array $map, string $symbol): array
    {
        foreach ($map as $y => $row) {
            foreach ($row as $x => $node) {
                if ($node === $symbol) {
                    return [$x, $y];
                }
            }
        }

        return [0, 0];
    }
}
