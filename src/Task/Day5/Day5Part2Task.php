<?php

declare(strict_types=1);

namespace Riimu\AdventOfCode2023\Task\Day5;

/**
 * @author Riikka Kalliomäki <riikka.kalliomaki@gmail.com>
 * @copyright Copyright (c) 2023 Riikka Kalliomäki
 * @license http://opensource.org/licenses/mit-license.php MIT License
 */
class Day5Part2Task extends AbstractDay5Task
{
    protected function solve(Day5Input $input): int
    {
        $ranges = [];

        foreach (array_chunk($input->seeds, 2) as [$start, $length]) {
            $ranges[] = [$start, $start + $length - 1];
        }

        foreach (self::INPUT_MAPS as $name) {
            $newRanges = [];

            foreach ($input->maps[$name] as $mapping) {
                $mapStart = $mapping->sourceStart;
                $mapEnd = $mapping->sourceStart + $mapping->length - 1;

                foreach ($ranges as $key => [$start, $end]) {
                    if ($mapStart > $end || $mapEnd < $start) {
                        continue;
                    }

                    unset($ranges[$key]);

                    if ($mapStart > $start) {
                        $ranges[] = [$start, $mapStart - 1];
                    }
                    if ($mapEnd < $end) {
                        $ranges[] = [$mapEnd + 1, $end];
                    }

                    $newRanges[] = [
                        $mapping->destinationStart + (max($start, $mapStart) - $mapStart),
                        $mapping->destinationStart + (min($end, $mapEnd) - $mapStart),
                    ];
                }
            }

            array_push($ranges, ...$newRanges);
        }

        return min(array_column($ranges, 0));
    }
}
