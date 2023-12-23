<?php

declare(strict_types=1);

namespace Riimu\AdventOfCode2023\Task\Day23;

use Riimu\AdventOfCode2023\Utility\Direction;

/**
 * @author Riikka Kalliomäki <riikka.kalliomaki@gmail.com>
 * @copyright Copyright (c) 2023 Riikka Kalliomäki
 * @license http://opensource.org/licenses/mit-license.php MIT License
 */
class Day23Part2Task extends AbstractDay23Task
{
    protected function isValidDirection(array $map, int $x, int $y, Direction $direction): bool
    {
        return isset($map[$y][$x]) && $map[$y][$x] !== Day23Input::NODE_WALL;
    }
}
