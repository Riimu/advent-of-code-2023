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
        $PotentialXSet = null;
        $PotentialYSet = null;
        $PotentialZSet = null;

        foreach ($this->combinations(\count($input->velocities)) as [$A, $B]) {
            list($APX, $APY, $APZ) = $input->hailstones[$A];
            list($AVX, $AVY, $AVZ) = $input->velocities[$A];
            list($BPX, $BPY, $BPZ) = $input->hailstones[$B];
            list($BVX, $BVY, $BVZ) = $input->velocities[$B];

            if ($AVX === $BVX && abs($AVX) > 100) {
                $NewXSet = array();
                $Difference = $BPX - $APX;
                for ($v = -1000; $v < 1000; $v++) {
                    if ($v === $AVX) {
                        continue;
                    }
                    if ($Difference % ($v - $AVX) == 0) {
                        $NewXSet[] = $v;
                    }
                }
                if ($PotentialXSet !== null) {
                    $PotentialXSet = array_intersect($PotentialXSet, $NewXSet);
                } else {
                    $PotentialXSet = $NewXSet;
                }
            }
            if ($AVY === $BVY && abs($AVY) > 100) {
                $NewYSet = array();
                $Difference = $BPY - $APY;
                for ($v = -1000; $v < 1000; $v++) {
                    if ($v === $AVY) {
                        continue;
                    }
                    if ($Difference % ($v - $AVY) === 0) {
                        $NewYSet[] = $v;
                    }
                }
                if ($PotentialYSet !== null) {
                    $PotentialYSet = array_intersect($PotentialYSet, $NewYSet);
                } else {
                    $PotentialYSet = $NewYSet;
                }
            }
            if ($AVZ === $BVZ && abs($AVZ) > 100) {
                $NewZSet = array();
                $Difference = $BPZ - $APZ;
                for ($v = -1000; $v < 1000; $v++) {
                    if ($v === $AVZ) {
                        continue;
                    }
                    if ($Difference % ($v - $AVZ) === 0) {
                        $NewZSet[] = $v;
                    }
                }
                if ($PotentialZSet !== null) {
                    $PotentialZSet = array_intersect($PotentialZSet, $NewZSet);
                } else {
                    $PotentialZSet = $NewZSet;
                }
            }

            if (\count($PotentialXSet ?? []) === 1 && \count($PotentialYSet ?? []) === 1 && \count($PotentialZSet ?? []) == 1) {
                break;
            }
        }

        $RVX = array_pop($PotentialXSet);
        $RVY = array_pop($PotentialYSet);
        $RVZ = array_pop($PotentialZSet);

        list($APX, $APY, $APZ) = $input->hailstones[0];
        list($AVX, $AVY, $AVZ) = $input->velocities[0];
        list($BPX, $BPY, $BPZ) = $input->hailstones[1];
        list($BVX, $BVY, $BVZ) = $input->velocities[1];

        $MA = ($AVY - $RVY) / ($AVX - $RVX);
        $MB = ($BVY - $RVY) / ($BVX - $RVX);
        $CA = $APY - ($MA * $APX);
        $CB = $BPY - ($MB * $BPX);
        $XPos = \intval(($CB - $CA) / ($MA - $MB));
        $YPos = \intval($MA * $XPos + $CA);
        $Time = ($XPos - $APX) / ($AVX - $RVX);
        $ZPos = $APZ + ($AVZ - $RVZ) * $Time;

        return $XPos + $YPos + $ZPos;
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
