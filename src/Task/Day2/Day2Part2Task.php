<?php

declare(strict_types=1);

namespace Riimu\AdventOfCode2023\Task\Day2;

/**
 * @author Riikka Kalliomäki <riikka.kalliomaki@gmail.com>
 * @copyright Copyright (c) 2023 Riikka Kalliomäki
 * @license http://opensource.org/licenses/mit-license.php MIT License
 */
class Day2Part2Task extends AbstractDay2Task
{
    protected function solve(Day2Input $input): int
    {
        $powers = [];

        foreach ($input->games as $game) {
            $minRed = 0;
            $minGreen = 0;
            $minBlue = 0;

            foreach ($game as $set) {
                $minRed = max($minRed, $set->red);
                $minGreen = max($minGreen, $set->green);
                $minBlue = max($minBlue, $set->blue);
            }

            $powers[] = $minRed * $minGreen * $minBlue;
        }

        return array_sum($powers);
    }
}
