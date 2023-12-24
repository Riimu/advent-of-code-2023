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
    // Courtesy of https://www.reddit.com/r/adventofcode/comments/18pnycy/2023_day_24_solutions/keqf8uq/
    protected function solve(Day24Input $input): int
    {
        $potentialXSet = null;
        $potentialYSet = null;
        $potentialZSet = null;

        foreach ($this->combinations(\count($input->velocities)) as [$a, $b]) {
            [$apx, $apy, $apz] = $input->hailstones[$a];
            [$avx, $avy, $avz] = $input->velocities[$a];
            [$bpx, $bpy, $bpz] = $input->hailstones[$b];
            [$bvx, $bvy, $bvz] = $input->velocities[$b];

            if ($avx === $bvx) {
                $NewXSet = [];
                $Difference = $bpx - $apx;
                for ($v = -1000; $v < 1000; $v++) {
                    if ($v === $avx || $Difference % ($v - $avx) === 0) {
                        $NewXSet[] = $v;
                    }
                }
                if ($potentialXSet !== null) {
                    $potentialXSet = array_intersect($potentialXSet, $NewXSet);
                } else {
                    $potentialXSet = $NewXSet;
                }
            }
            if ($avy === $bvy) {
                $NewYSet = [];
                $Difference = $bpy - $apy;
                for ($v = -1000; $v < 1000; $v++) {
                    if ($v === $avy || $Difference % ($v - $avy) === 0) {
                        $NewYSet[] = $v;
                    }
                }
                if ($potentialYSet !== null) {
                    $potentialYSet = array_intersect($potentialYSet, $NewYSet);
                } else {
                    $potentialYSet = $NewYSet;
                }
            }
            if ($avz === $bvz) {
                $NewZSet = [];
                $Difference = $bpz - $apz;
                for ($v = -1000; $v < 1000; $v++) {
                    if ($v === $avz || $Difference % ($v - $avz) === 0) {
                        $NewZSet[] = $v;
                    }
                }
                if ($potentialZSet !== null) {
                    $potentialZSet = array_intersect($potentialZSet, $NewZSet);
                } else {
                    $potentialZSet = $NewZSet;
                }
            }

            if (\count($potentialXSet ?? []) === 1 && \count($potentialYSet ?? []) === 1 && \count($potentialZSet ?? []) == 1) {
                break;
            }
        }

        $xv = array_pop($potentialXSet);
        $yv = array_pop($potentialYSet);
        $zv = array_pop($potentialZSet);

        [$apx, $apy, $apz] = $input->hailstones[0];
        [$avx, $avy, $avz] = $input->velocities[0];
        [$bpx, $bpy, $bpz] = $input->hailstones[1];
        [$bvx, $bvy, $bvz] = $input->velocities[1];

        $ma = ($avy - $yv) / ($avx - $xv);
        $mb = ($bvy - $yv) / ($bvx - $xv);
        $ca = $apy - ($ma * $apx);
        $cb = $bpy - ($mb * $bpx);
        $x = \intval(($cb - $ca) / ($ma - $mb));
        $y = \intval($ma * $x + $ca);
        $time = ($x - $apx) / ($avx - $xv);
        $z = $apz + ($avz - $zv) * $time;

        return $x + $y + $z;
    }

    private function combinations(int $count): iterable
    {
        for ($i = 0; $i < $count; $i++) {
            for ($j = $i + 1; $j < $count; $j++) {
                yield [$i, $j];
            }
        }
    }
}
