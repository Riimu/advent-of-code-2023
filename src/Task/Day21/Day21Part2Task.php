<?php

declare(strict_types=1);

namespace Riimu\AdventOfCode2023\Task\Day21;

/**
 * @author Riikka Kalliomäki <riikka.kalliomaki@gmail.com>
 * @copyright Copyright (c) 2023 Riikka Kalliomäki
 * @license http://opensource.org/licenses/mit-license.php MIT License
 */
class Day21Part2Task extends AbstractDay21Task
{
    protected const MAX_STEPS = 26501365;

    protected function solve(Day21Input $input): int
    {
        $height = \count($input->map);
        $width = \count($input->map[0]);
        [$startX, $startY] = $this->findSymbol($input->map, Day21Input::NODE_START);

        $toLeft = $startX + 1;
        $toRight = $width - $startX;
        $toUp = $startY + 1;
        $toDown = $height - $startY;

        $totalReachable =
            $this->countStraightReachable($input->map, $width - 1, $startY, self::MAX_STEPS - $toLeft, $width) +
            $this->countStraightReachable($input->map, 0, $startY, self::MAX_STEPS - $toRight, $width) +
            $this->countStraightReachable($input->map, $startX, $height - 1, self::MAX_STEPS - $toUp, $height) +
            $this->countStraightReachable($input->map, $startX, 0, self::MAX_STEPS - $toDown, $height);

        $totalReachable +=
            $this->countDiagonalReachable($input->map, $width - 1, $height - 1, self::MAX_STEPS - $toLeft - $toUp) +
            $this->countDiagonalReachable($input->map, $width - 1, 0, self::MAX_STEPS - $toLeft - $toDown) +
            $this->countDiagonalReachable($input->map, 0, $height - 1, self::MAX_STEPS - $toRight - $toUp) +
            $this->countDiagonalReachable($input->map, 0, 0, self::MAX_STEPS - $toRight - $toDown);

        return $totalReachable;
    }

    private function countStraightReachable(array $map, int $originX, int $originY, int $maxSteps, int $interval): int
    {
        $stepsCounts = $this->countStepsFrom($map, $originX, $originY);
        return $this->calculateLoopReachable($stepsCounts, $maxSteps, $interval);
    }

    private function countDiagonalReachable(array $map, int $originX, int $originY, int $maxSteps): int
    {
        $stepsFromBottomRight = $this->countStepsFrom($map, $originX, $originY);
        $reachableCache = [];
        $totalReachable = 0;
        $height = \count($map);
        $width = \count($map[0]);

        for ($i = 0; $i <= $maxSteps; $i += $width) {
            $totalReachable += $this->calculateLoopReachable($stepsFromBottomRight, $maxSteps - $i, $height, $reachableCache);
        }

        return $totalReachable;
    }

    private function calculateLoopReachable(array $stepCounts, int $maxSteps, int $length, array &$reachableCache = []): int
    {
        $remainingSteps = $maxSteps;
        $fullMaps = intdiv($remainingSteps, $length);
        $remainingSteps = $remainingSteps % $length;
        $totalReachable = 0;

        $reachableCache[\PHP_INT_MAX] ??= $this->countReachable($stepCounts, \PHP_INT_MAX);
        $reachableCache[-1] ??= max(array_map(max(...), $stepCounts));
        $maxStepsRequired = $reachableCache[-1];

        while (true) {
            $reachableCache[$remainingSteps] ??= $this->countReachable($stepCounts, $remainingSteps);
            $totalReachable += $reachableCache[$remainingSteps];
            $remainingSteps += $length;

            if ($remainingSteps >= $maxStepsRequired || $fullMaps === 0) {
                break;
            }

            $fullMaps--;
        }

        return $totalReachable + $fullMaps * $reachableCache[\PHP_INT_MAX];
    }
}
