<?php

declare(strict_types=1);

namespace Riimu\AdventOfCode2023\Task\Day12;

/**
 * @author Riikka Kalliomäki <riikka.kalliomaki@gmail.com>
 * @copyright Copyright (c) 2023 Riikka Kalliomäki
 * @license http://opensource.org/licenses/mit-license.php MIT License
 */
class Day12Part1Task extends AbstractDay12Task
{
    protected function solve(Day12Input $input): int
    {
        $arrangements = [];

        foreach ($input->records as $record) {
            $arrangements[] = $this->tryArrangements($record->condition, $record->groups);
        }

        return array_sum($arrangements);
    }
}
