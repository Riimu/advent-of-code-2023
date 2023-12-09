<?php

declare(strict_types=1);

namespace Riimu\AdventOfCode2023\Task\Day9;

/**
 * @author Riikka Kalliomäki <riikka.kalliomaki@gmail.com>
 * @copyright Copyright (c) 2023 Riikka Kalliomäki
 * @license http://opensource.org/licenses/mit-license.php MIT License
 */
class Day9Part1Task extends AbstractDay9Task
{
    protected function calculateExtrapolatedValue(array $changes): int
    {
        $next = 0;

        for ($i = \count($changes) - 1; $i > 0; $i--) {
            $next += $changes[$i - 1][array_key_last($changes[$i - 1])];
        }

        return $next;
    }
}
