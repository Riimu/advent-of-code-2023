<?php

declare(strict_types=1);

namespace Riimu\AdventOfCode2023\Task\Day10;

/**
 * @author Riikka Kalliomäki <riikka.kalliomaki@gmail.com>
 * @copyright Copyright (c) 2023 Riikka Kalliomäki
 * @license http://opensource.org/licenses/mit-license.php MIT License
 */
class Day10Part2Task extends AbstractDay10Task
{
    protected function solve(Day10Input $input): int
    {
        $pipe = $this->findValidPipes($input->map)[0];
        [$startX, $startY] = $pipe[0];
        $fill = [];

        foreach ($input->map as $y => $row) {
            foreach ($row as $x => $node) {
                $fill[$y][$x] = true;
            }
        }

        foreach ($pipe as [$x, $y]) {
            $fill[$y][$x] = null;
        }

        $map = $input->map;

        foreach ($map as $y => $row) {
            foreach ($row as $x => $node) {
                if ($fill[$y][$x]) {
                    $map[$y][$x] = '.';
                }
            }
        }

        [$topLeftX, $topLeftY] = $this->find($map, 'F');

        if ($startY < $topLeftY) {
            $topLeftX = $startX;
            $topLeftY = $startY;
        }

        $x = $topLeftX;
        $y = $topLeftY;
        $direction = Direction::RIGHT;

        do {
            $moveDirection = $direction;

            [$x, $y] = $this->moveDirection($x, $y, $direction);
            $direction = $this->getNextDirection($map, $x, $y, $direction);

            if ($moveDirection === Direction::RIGHT || $direction === Direction::RIGHT) {
                for ($nextY = $y + 1; $fill[$nextY][$x]; $nextY++) {
                    $fill[$nextY][$x] = false;
                }
            }
        } while ($x !== $topLeftX || $y !== $topLeftY);

        return array_sum(array_map(
            static fn(array $x): int => \count(array_keys($x, false, true)),
            $fill
        ));
    }
}
