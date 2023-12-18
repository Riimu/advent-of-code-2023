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
    protected function solve(Day18Input $input): int
    {
        $totalLength = 0;
        $points = [];
        $x = 0;
        $y = 0;

        foreach ($input->instructions as $instruction) {
            $distance = $instruction->color >> 4;
            $direction = match ($instruction->color & 0xF) {
                0 => Direction::RIGHT,
                1 => Direction::DOWN,
                2 => Direction::LEFT,
                3 => Direction::UP,
                default => throw new \UnexpectedValueException('Unexpected directional value'),
            };

            $totalLength += $distance;
            [$x, $y] = $direction->moveCoordinates($x, $y, $distance);
            $points[] = [$x, $y];
        }

        $area = 0;
        $count = \count($points);

        for ($i = 0; $i < $count; $i++) {
            $previous = $i === 0 ? $count - 1 : $i - 1;
            $next = ($i + 1) % $count;

            $area += $points[$i][1] * ($points[$previous][0] - $points[$next][0]);
        }

        $area = abs($area / 2);
        $internalPoints = $area - ($totalLength / 2) + 1;

        return $internalPoints + $totalLength;
    }
}
