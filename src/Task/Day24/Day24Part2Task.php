<?php

declare(strict_types=1);

namespace Riimu\AdventOfCode2023\Task\Day24;

/**
 * @author Riikka Kalliomäki <riikka.kalliomaki@gmail.com>
 * @copyright Copyright (c) 2023 Riikka Kalliomäki
 * @license http://opensource.org/licenses/mit-license.php MIT License
 */
class Day24Part2Task extends AbstractDay24Task
{
    private const INDEX_X = 0;
    private const INDEX_Y = 1;
    private const INDEX_Z = 2;

    // Courtesy of https://www.reddit.com/r/adventofcode/comments/18pnycy/2023_day_24_solutions/keqf8uq/
    protected function solve(Day24Input $input): int
    {
        $potentialSet = [self::INDEX_X => null, self::INDEX_Y => null, self::INDEX_Z => null];

        foreach ($this->combinations(\count($input->velocities)) as [$a, $b]) {
            foreach ([self::INDEX_X, self::INDEX_Y, self::INDEX_Z] as $i) {
                $velocityA = $input->velocities[$a][$i];
                $velocityB = $input->velocities[$b][$i];

                if ($velocityA === $velocityB) {
                    $newSet = [];
                    $difference = $input->hailstones[$b][$i] - $input->hailstones[$a][$i];

                    for ($velocity = -1000; $velocity < 1000; $velocity++) {
                        if ($velocity === $velocityA || $difference % ($velocity - $velocityA) === 0) {
                            $newSet[] = $velocity;
                        }
                    }

                    $potentialSet[$i] ??= $newSet;
                    $potentialSet[$i] = array_intersect($potentialSet[$i], $newSet);
                }
            }

            if ($this->isSolutionFound($potentialSet)) {
                break;
            }
        }

        if ($potentialSet[self::INDEX_X] === null || $potentialSet[self::INDEX_Y] === null || $potentialSet[self::INDEX_Z] === null) {
            throw new \UnexpectedValueException("Could not find an answer");
        }

        $xv = array_pop($potentialSet[self::INDEX_X]);
        $yv = array_pop($potentialSet[self::INDEX_Y]);
        $zv = array_pop($potentialSet[self::INDEX_Z]);

        [$apx, $apy, $apz] = $input->hailstones[0];
        [$avx, $avy, $avz] = $input->velocities[0];
        [$bpx, $bpy, $bpz] = $input->hailstones[1];
        [$bvx, $bvy, $bvz] = $input->velocities[1];

        $ma = ($avy - $yv) / ($avx - $xv);
        $mb = ($bvy - $yv) / ($bvx - $xv);
        $ca = $apy - ($ma * $apx);
        $cb = $bpy - ($mb * $bpx);
        $x = (int) (($cb - $ca) / ($ma - $mb));
        $y = (int) ($ma * $x + $ca);
        $time = ($x - $apx) / ($avx - $xv);
        $z = $apz + ($avz - $zv) * $time;

        return $x + $y + $z;
    }

    /**
     * @param int $count
     * @return iterable<array{0: int, 1: int}>
     */
    private function combinations(int $count): iterable
    {
        for ($i = 0; $i < $count; $i++) {
            for ($j = $i + 1; $j < $count; $j++) {
                yield [$i, $j];
            }
        }
    }

    /**
     * @param array<null|array<int, int>> $sets
     * @return bool
     */
    private function isSolutionFound(array $sets): bool
    {
        foreach ($sets as $set) {
            if ($set === null || \count($set) !== 1) {
                return false;
            }
        }

        return true;
    }
}
