<?php

declare(strict_types=1);

namespace Riimu\AdventOfCode2023\Task\Day16;

use Riimu\AdventOfCode2023\Utility\Direction;

/**
 * @author Riikka Kalliomäki <riikka.kalliomaki@gmail.com>
 * @copyright Copyright (c) 2023 Riikka Kalliomäki
 * @license http://opensource.org/licenses/mit-license.php MIT License
 */
class Day16Part2Task extends AbstractDay16Task
{
    protected function solve(Day16Input $input): int
    {
        $maximum = 0;
        $height = \count($input->map);
        $width = \count($input->map[0]);

        for ($i = 0; $i < $height; $i++) {
            $maximum = max(
                $maximum,
                $this->countEnergized($input->map, 0, $i, Direction::RIGHT),
                $this->countEnergized($input->map, $width - 1, $i, Direction::LEFT)
            );
        }

        for ($i = 0; $i < $width; $i++) {
            $maximum = max(
                $maximum,
                $this->countEnergized($input->map, $i, 0, Direction::DOWN),
                $this->countEnergized($input->map, $i, $height - 1, Direction::UP)
            );
        }

        return $maximum;
    }
}
