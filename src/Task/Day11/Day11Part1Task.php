<?php

declare(strict_types=1);

namespace Riimu\AdventOfCode2023\Task\Day11;

/**
 * @author Riikka Kalliomäki <riikka.kalliomaki@gmail.com>
 * @copyright Copyright (c) 2023 Riikka Kalliomäki
 * @license http://opensource.org/licenses/mit-license.php MIT License
 */
class Day11Part1Task extends AbstractDay11Task
{
    protected function solve(Day11Input $input): int
    {
        $rows = [];

        foreach ($input->map as $row) {
            $rows[] = $row;

            if (array_values(array_unique($row)) === ['.']) {
                $rows[] = $row;
            }
        }

        $columns = [];

        foreach (array_keys($rows[array_key_first($rows)]) as $x) {
            $column = array_column($rows, $x);
            $columns[] = $column;

            if (array_values(array_unique($column)) === ['.']) {
                $columns[] = $column;
            }
        }

        $stars = [];

        foreach ($columns as $x => $column) {
            foreach ($column as $y => $node) {
                if ($node === '#') {
                    $stars[] = [$x, $y];
                }
            }
        }

        $lengths = [];

        foreach ($stars as $key => [$x, $y]) {
            foreach (\array_slice($stars, $key + 1) as [$targetX, $targetY]) {
                $lengths[] = abs($targetX - $x) + abs($targetY - $y);
            }
        }

        return array_sum($lengths);
    }
}
