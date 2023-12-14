<?php

declare(strict_types=1);

namespace Riimu\AdventOfCode2023\Task\Day14;

/**
 * @author Riikka Kalliomäki <riikka.kalliomaki@gmail.com>
 * @copyright Copyright (c) 2023 Riikka Kalliomäki
 * @license http://opensource.org/licenses/mit-license.php MIT License
 */
class Day14Part1Task extends AbstractDay14Task
{
    protected function solve(Day14Input $input): int
    {
        $tilted = $input->map;

        foreach ($tilted as $y => $row) {
            if ($y === 0) {
                continue;
            }

            foreach ($row as $x => $node) {
                if ($node !== 'O') {
                    continue;
                }

                for ($i = $y; $i > 0; $i--) {
                    if ($tilted[$i - 1][$x] !== '.') {
                        continue 2;
                    }

                    $tilted[$i][$x] = '.';
                    $tilted[$i - 1][$x] = 'O';
                }
            }
        }

        $height = \count($tilted);
        $weights = [];

        foreach ($tilted as $y => $row) {
            foreach ($row as $node) {
                if ($node === 'O') {
                    $weights[] = $height - $y;
                }
            }
        }

        return array_sum($weights);
    }
}
