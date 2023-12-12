<?php

declare(strict_types=1);

namespace Riimu\AdventOfCode2023\Task\Day12;

/**
 * @author Riikka Kalliomäki <riikka.kalliomaki@gmail.com>
 * @copyright Copyright (c) 2023 Riikka Kalliomäki
 * @license http://opensource.org/licenses/mit-license.php MIT License
 */
class Day12Part2Task extends AbstractDay12Task
{
    protected function solve(Day12Input $input): int
    {
        $arrangements = [];

        foreach ($input->records as $record) {
            $arrangements[] = $this->tryArrangements(
                implode('?', array_fill(0, 5, $record->condition)),
                array_merge(...array_fill(0, 5, $record->groups))
            );
        }

        return array_sum($arrangements);
    }
}
