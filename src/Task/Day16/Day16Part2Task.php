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

        $visitedExits = [];
        $entryPoints = [];

        for ($i = 0; $i < $height; $i++) {
            $entryPoints[] = [0, $i, Direction::RIGHT];
            $entryPoints[] = [$width - 1, $i, Direction::LEFT];
        }

        for ($i = 0; $i < $width; $i++) {
            $entryPoints[] = [$i, 0, Direction::DOWN];
            $entryPoints[] = [$i, $height - 1, Direction::UP];
        }

        foreach ($entryPoints as [$x, $y, $direction]) {
            if (isset($visitedExits[$y][$x][$direction->value])) {
                continue;
            }

            $maximum = max($maximum, $this->countEnergized($input->map, $x, $y, $direction, $visitedExits));
        }

        return $maximum;
    }
}
