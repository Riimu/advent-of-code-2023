<?php

declare(strict_types=1);

namespace Riimu\AdventOfCode2023\Task\Day2;

/**
 * @author Riikka Kalliomäki <riikka.kalliomaki@gmail.com>
 * @copyright Copyright (c) 2023 Riikka Kalliomäki
 * @license http://opensource.org/licenses/mit-license.php MIT License
 */
class Day2Part1Task extends AbstractDay2Task
{
    protected function solve(Day2Input $input): int
    {
        $possible = [];
        $maxRed = 12;
        $maxGreen = 13;
        $maxBlue = 14;

        foreach ($input->games as $number => $game) {
            foreach ($game as $set) {
                if ($set->red > $maxRed || $set->green > $maxGreen || $set->blue > $maxBlue) {
                    continue 2;
                }
            }

            $possible[] = $number;
        }

        return array_sum($possible);
    }
}
