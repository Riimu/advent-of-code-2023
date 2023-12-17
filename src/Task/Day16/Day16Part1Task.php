<?php

declare(strict_types=1);

namespace Riimu\AdventOfCode2023\Task\Day16;

use Riimu\AdventOfCode2023\Utility\Direction;

/**
 * @author Riikka Kalliomäki <riikka.kalliomaki@gmail.com>
 * @copyright Copyright (c) 2023 Riikka Kalliomäki
 * @license http://opensource.org/licenses/mit-license.php MIT License
 */
class Day16Part1Task extends AbstractDay16Task
{
    protected function solve(Day16Input $input): int
    {
        return $this->countEnergized($input->map, 0, 0, Direction::RIGHT);
    }
}
