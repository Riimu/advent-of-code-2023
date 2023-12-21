<?php

declare(strict_types=1);

namespace Riimu\AdventOfCode2023\Task\Day21;

/**
 * @author Riikka Kalliomäki <riikka.kalliomaki@gmail.com>
 * @copyright Copyright (c) 2023 Riikka Kalliomäki
 * @license http://opensource.org/licenses/mit-license.php MIT License
 */
class Day21Part1Task extends AbstractDay21Task
{
    private const MAX_STEPS = 64;

    protected function solve(Day21Input $input): int
    {
        [$startX, $startY] = $this->findSymbol($input->map, Day21Input::NODE_START);
        $stepCounts = $this->countStepsFrom($input->map, $startX, $startY);
        return $this->countReachable($stepCounts, self::MAX_STEPS);
    }
}
