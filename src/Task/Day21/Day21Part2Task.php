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
    private const MAX_STEPS = 26501365;
    private const CACHE_MAX = -1;
    private const CACHE_EVEN = -2;
    private const CACHE_ODD = -3;

    protected function solve(Day21Input $input): int
    {
        $height = \count($input->map);
        $width = \count($input->map[0]);
        [$startX, $startY] = $this->findSymbol($input->map, Day21Input::NODE_START);

        $toLeft = $startX + 1;
        $toRight = $width - $startX;
        $toUp = $startY + 1;
        $toDown = $height - $startY;

        $totalReachable = $this->countReachable($this->countStepsFrom($input->map, $startX, $startY), self::MAX_STEPS);

        $totalReachable +=
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

    /**
     * @param array<int, array<int, string>> $map
     * @param int $originX
     * @param int $originY
     * @param int $maxSteps
     * @param int $interval
     * @return int
     */
    private function countStraightReachable(array $map, int $originX, int $originY, int $maxSteps, int $interval): int
    {
        $stepsCounts = $this->countStepsFrom($map, $originX, $originY);
        return $this->calculateLoopReachable($stepsCounts, $maxSteps, $interval);
    }

    /**
     * @param array<int, array<int, string>> $map
     * @param int $originX
     * @param int $originY
     * @param int $maxSteps
     * @return int
     */
    private function countDiagonalReachable(array $map, int $originX, int $originY, int $maxSteps): int
    {
        $stepCounts = $this->countStepsFrom($map, $originX, $originY);
        $reachableCache = [];
        $totalReachable = 0;
        $height = \count($map);
        $width = \count($map[0]);

        for ($i = 0; $i <= $maxSteps; $i += $width) {
            $totalReachable += $this->calculateLoopReachable($stepCounts, $maxSteps - $i, $height, $reachableCache);
        }

        return $totalReachable;
    }

    /**
     * @param array<int, array<int, int|null>> $stepCounts
     * @param int $maxSteps
     * @param int $length
     * @param array<int, int> $reachableCache
     * @return int
     */
    private function calculateLoopReachable(array $stepCounts, int $maxSteps, int $length, array &$reachableCache = []): int
    {
        $remainingSteps = $maxSteps;
        $fullMaps = intdiv($remainingSteps, $length);
        $remainingSteps %= $length;
        $totalReachable = 0;

        $reachableCache[self::CACHE_MAX] ??= max(array_map(static fn(array $x): int => max($x) ?? 0, $stepCounts));
        $reachableCache[self::CACHE_EVEN] ??= $this->countReachable($stepCounts, 10 ** (int) log($reachableCache[-1] * 10, 10));
        $reachableCache[self::CACHE_ODD] ??= $this->countReachable($stepCounts, 1 + 10 ** (int) log($reachableCache[-1] * 10, 10));

        while (true) {
            $reachableCache[$remainingSteps] ??= $this->countReachable($stepCounts, $remainingSteps);
            $totalReachable += $reachableCache[$remainingSteps];
            $remainingSteps += $length;

            if ($remainingSteps >= $reachableCache[self::CACHE_MAX] || $fullMaps === 0) {
                break;
            }

            $fullMaps--;
        }

        $evenMaps = intdiv($fullMaps + 1, 2);
        $oddMaps = intdiv($fullMaps, 2);

        if ($maxSteps % 2 === 1) {
            [$evenMaps, $oddMaps] = [$oddMaps, $evenMaps];
        }

        return $totalReachable + $evenMaps * $reachableCache[self::CACHE_EVEN] + $oddMaps * $reachableCache[self::CACHE_ODD];
    }
}
