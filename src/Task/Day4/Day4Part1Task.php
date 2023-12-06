<?php

declare(strict_types=1);

namespace Riimu\AdventOfCode2023\Task\Day4;

/**
 * @author Riikka Kalliomäki <riikka.kalliomaki@gmail.com>
 * @copyright Copyright (c) 2023 Riikka Kalliomäki
 * @license http://opensource.org/licenses/mit-license.php MIT License
 */
class Day4Part1Task extends AbstractDay4Task
{
    protected function solve(Day4Input $input): int
    {
        $cardPoints = [];

        foreach ($input->scratchCards as $card) {
            $hits = \count(array_intersect($card->winningNumbers, $card->cardNumbers));
            $cardPoints[] = $hits > 0 ? 2 ** ($hits - 1) : 0;
        }

        return array_sum($cardPoints);
    }
}
