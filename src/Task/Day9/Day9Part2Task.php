<?php

declare(strict_types=1);

namespace Riimu\AdventOfCode2023\Task\Day9;

/**
 * @author Riikka Kalliomäki <riikka.kalliomaki@gmail.com>
 * @copyright Copyright (c) 2023 Riikka Kalliomäki
 * @license http://opensource.org/licenses/mit-license.php MIT License
 */
class Day9Part2Task extends AbstractDay9Task
{
    protected function solve(Day9Input $input): int
    {
        $extrapolated = [];

        foreach ($input->histories as $history) {
            $changes = [$history];

            while (array_unique($history) !== [0]) {
                $previous = $history;
                $history = [];

                $count = \count($previous);

                for ($i = 1; $i < $count; $i++) {
                    $history[] = $previous[$i] - $previous[$i - 1];
                }

                $changes[] = $history;
            }

            $next = 0;

            for ($i = \count($changes) - 1; $i > 0; $i--) {
                $next = $changes[$i - 1][0] - $next;
            }

            $extrapolated[] = $next;
        }

        return array_sum($extrapolated);
    }
}
