<?php

declare(strict_types=1);

namespace Riimu\AdventOfCode2023\Task\Day4;

/**
 * @author Riikka Kalliomäki <riikka.kalliomaki@gmail.com>
 * @copyright Copyright (c) 2023 Riikka Kalliomäki
 * @license http://opensource.org/licenses/mit-license.php MIT License
 */
class Day4Part2Task extends AbstractDay4Task
{
    protected function solve(Day4Input $input): int
    {
        $totalCards = array_fill(0, \count($input->scratchCards), 1);

        foreach ($input->scratchCards as $index => $card) {
            $hits = \count(array_intersect($card->winningNumbers, $card->cardNumbers));

            for ($i = 1; $i <= $hits && isset($totalCards[$index + $i]); $i++) {
                $totalCards[$index + $i] += $totalCards[$index];
            }
        }

        return array_sum($totalCards);
    }
}
