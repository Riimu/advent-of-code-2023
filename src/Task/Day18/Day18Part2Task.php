<?php

declare(strict_types=1);

namespace Riimu\AdventOfCode2023\Task\Day18;

use Riimu\AdventOfCode2023\Utility\Direction;

/**
 * @author Riikka Kalliomäki <riikka.kalliomaki@gmail.com>
 * @copyright Copyright (c) 2023 Riikka Kalliomäki
 * @license http://opensource.org/licenses/mit-license.php MIT License
 */
class Day18Part2Task extends AbstractDay18Task
{
    protected function getDirection(Instruction $instruction): Direction
    {
        return match ($instruction->color & 0xF) {
            0 => Direction::RIGHT,
            1 => Direction::DOWN,
            2 => Direction::LEFT,
            3 => Direction::UP,
            default => throw new \UnexpectedValueException('Unexpected directional value'),
        };
    }

    protected function getDistance(Instruction $instruction): int
    {
        return $instruction->color >> 4;
    }
}
