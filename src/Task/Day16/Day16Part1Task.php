<?php

declare(strict_types=1);

namespace Riimu\AdventOfCode2023\Task\Day16;

/**
 * @author Riikka Kalliomäki <riikka.kalliomaki@gmail.com>
 * @copyright Copyright (c) 2023 Riikka Kalliomäki
 * @license http://opensource.org/licenses/mit-license.php MIT License
 */
class Day16Part1Task extends AbstractDay16Task
{
    protected function solve(Day16Input $input): int
    {
        $beams = [[0, 0, Direction::RIGHT]];
        $moveDirections = [];

        do {
            $newBeams = [];

            foreach ($beams as [$x, $y, $direction]) {
                if (isset($moveDirections[$y][$x][$direction->value])) {
                    continue;
                }

                $moveDirections[$y][$x][$direction->value] = true;
                array_push($newBeams, ...$this->moveBeam($input->map, $x, $y, $direction));
            }

            $beams = $newBeams;
        } while ($beams !== []);

        return array_sum(array_map(\count(...), $moveDirections));
    }
}
