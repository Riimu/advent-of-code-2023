<?php

declare(strict_types=1);

namespace Riimu\AdventOfCode2023\Task\Day18;

use Riimu\AdventOfCode2023\Utility\Direction;

/**
 * @author Riikka Kalliomäki <riikka.kalliomaki@gmail.com>
 * @copyright Copyright (c) 2023 Riikka Kalliomäki
 * @license http://opensource.org/licenses/mit-license.php MIT License
 */
class Day18Part1Task extends AbstractDay18Task
{
    protected function getDirection(Instruction $instruction): Direction
    {
        return $instruction->direction;
    }

    protected function getDistance(Instruction $instruction): int
    {
        return $instruction->distance;
    }
}
