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
    protected function calculateExtrapolatedValue(array $changes): int
    {
        $previous = 0;

        for ($i = \count($changes) - 1; $i > 0; $i--) {
            $previous = $changes[$i - 1][0] - $previous;
        }

        return $previous;
    }
}
