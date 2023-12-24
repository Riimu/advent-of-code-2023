<?php

declare(strict_types=1);

namespace Riimu\AdventOfCode2023\Task\Day24;

/**
 * @author Riikka Kalliomäki <riikka.kalliomaki@gmail.com>
 * @copyright Copyright (c) 2023 Riikka Kalliomäki
 * @license http://opensource.org/licenses/mit-license.php MIT License
 */
class Day24Part1Task extends AbstractDay24Task
{
    private const AREA_MIN = 200_000_000_000_000.0;
    private const AREA_MAX = 400_000_000_000_000.0;

    protected function solve(Day24Input $input): int
    {
        $intersections = 0;
        $count = \count($input->hailstones);

        for ($i = 0; $i < $count; $i++) {
            for ($j = $i + 1; $j < $count; $j++) {
                $intersection = $this->getIntersection(
                    $input->hailstones[$i][0],
                    $input->hailstones[$i][1],
                    $input->hailstones[$i][0] + ($input->velocities[$i][0] * 1000000),
                    $input->hailstones[$i][1] + ($input->velocities[$i][1] * 1000000),
                    $input->hailstones[$j][0],
                    $input->hailstones[$j][1],
                    $input->hailstones[$j][0] + ($input->velocities[$j][0] * 1000000),
                    $input->hailstones[$j][1] + ($input->velocities[$j][1] * 1000000),
                );

                if ($intersection === null) {
                    continue;
                }

                [$x, $y] = $intersection;

                if ($x >= self::AREA_MIN && $x <= self::AREA_MAX && $y >= self::AREA_MIN && $y <= self::AREA_MAX) {
                    $inFutureForA = ($input->velocities[$i][0] <=> 0) === ($x <=> $input->hailstones[$i][0]);
                    $inFutureForB = ($input->velocities[$j][0] <=> 0) === ($x <=> $input->hailstones[$j][0]);

                    if ($inFutureForA && $inFutureForB) {
                        $intersections++;
                    }
                }
            }
        }

        return $intersections;
    }

    /**
     * @param int $x1
     * @param int $y1
     * @param int $x2
     * @param int $y2
     * @param int $x3
     * @param int $y3
     * @param int $x4
     * @param int $y4
     * @return array{0: float, 1: float}|null
     */
    private function getIntersection(int $x1, int $y1, int $x2, int $y2, int $x3, int $y3, int $x4, int $y4): ?array
    {
        $denominator = ($x1 - $x2) * ($y3 - $y4) - ($y1 - $y2) * ($x3 - $x4);

        if ($denominator === 0) {
            return null;
        }

        return [
            (float) ((($x1 * $y2 - $y1 * $x2) * ($x3 - $x4) - ($x1 - $x2) * ($x3 * $y4 - $y3 * $x4)) / $denominator),
            (float) ((($x1 * $y2 - $y1 * $x2) * ($y3 - $y4) - ($y1 - $y2) * ($x3 * $y4 - $y3 * $x4)) / $denominator),
        ];
    }
}
