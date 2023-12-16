<?php

declare(strict_types=1);

namespace Riimu\AdventOfCode2023\Task\Day16;

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

    /**
     * @param array<int, array<int, string>> $map
     * @param int $startX
     * @param int $startY
     * @param Direction $startDirection
     * @return int
     */
    private function countEnergized(array $map, int $startX, int $startY, Direction $startDirection): int
    {
        $beams = [[$startX, $startY, $startDirection]];
        $moveDirections = [];

        do {
            $newBeams = [];

            foreach ($beams as [$x, $y, $direction]) {
                if (isset($moveDirections[$y][$x][$direction->value])) {
                    continue;
                }

                $moveDirections[$y][$x][$direction->value] = true;
                array_push($newBeams, ...$this->moveBeam($map, $x, $y, $direction));
            }

            $beams = $newBeams;
        } while ($beams !== []);

        return array_sum(array_map(\count(...), $moveDirections));
    }
}
