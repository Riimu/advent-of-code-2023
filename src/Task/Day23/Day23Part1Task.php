<?php

declare(strict_types=1);

namespace Riimu\AdventOfCode2023\Task\Day23;

use Riimu\AdventOfCode2023\Utility\Direction;

/**
 * @author Riikka Kalliomäki <riikka.kalliomaki@gmail.com>
 * @copyright Copyright (c) 2023 Riikka Kalliomäki
 * @license http://opensource.org/licenses/mit-license.php MIT License
 */
class Day23Part1Task extends AbstractDay23Task
{
    protected function isValidDirection(array $map, int $x, int $y, Direction $direction): bool
    {
        if (!isset($map[$y][$x])) {
            return false;
        }

        return match ($map[$y][$x]) {
            Day23Input::NODE_WALL => false,
            Day23Input::NODE_SLOPE_LEFT => $direction !== Direction::RIGHT,
            Day23Input::NODE_SLOPE_RIGHT => $direction !== Direction::LEFT,
            Day23Input::NODE_SLOPE_UP => $direction !== Direction::DOWN,
            Day23Input::NODE_SLOPE_DOWN => $direction !== Direction::UP,
            default => true,
        };
    }
}
