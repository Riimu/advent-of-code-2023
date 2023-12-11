<?php

declare(strict_types=1);

namespace Riimu\AdventOfCode2023\Task\Day11;

/**
 * @author Riikka Kalliomäki <riikka.kalliomaki@gmail.com>
 * @copyright Copyright (c) 2023 Riikka Kalliomäki
 * @license http://opensource.org/licenses/mit-license.php MIT License
 */
class Day11Part2Task extends AbstractDay11Task
{
    protected function solve(Day11Input $input): int
    {
        $columnLengths = [];
        $rowLengths = [];
        $expansion = 1_000_000;

        foreach ($input->map as $y => $row) {
            $rowLengths[$y] = $this->isEmpty($row) ? $expansion : 1;
        }

        $width = \count($input->map[0]);

        for ($x = 0; $x < $width; $x++) {
            $columnLengths[$x] = $this->isEmpty(array_column($input->map, $x)) ? $expansion : 1;
        }

        $stars = $this->findStars($input->map);
        $lengths = [];

        foreach ($stars as $index => [$x, $y]) {
            foreach (\array_slice($stars, $index + 1) as [$targetX, $targetY]) {
                $lengths[] =
                    array_sum(\array_slice($columnLengths, min($x, $targetX) + 1, abs($targetX - $x))) +
                    array_sum(\array_slice($rowLengths, min($y, $targetY) + 1, abs($targetY - $y)));
            }
        }

        return array_sum($lengths);
    }

    private function isEmpty(array $items): bool
    {
        return array_values(array_unique($items)) === ['.'];
    }

    /**
     * @param array<int, array<int, string>> $map
     * @return array<int, array<int, int>>
     */
    private function findStars(array $map): array
    {
        $stars = [];

        foreach ($map as $y => $row) {
            foreach ($row as $x => $node) {
                if ($node === '#') {
                    $stars[] = [$x, $y];
                }
            }
        }

        return $stars;
    }
}
