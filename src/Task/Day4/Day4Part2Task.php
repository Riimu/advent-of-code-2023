<?php

declare(strict_types=1);

namespace Riimu\AdventOfCode2023\Task\Day4;

use Riimu\AdventOfCode2023\TaskInputInterface;
use Riimu\AdventOfCode2023\TaskInterface;

/**
 * @author Riikka Kalliomäki <riikka.kalliomaki@gmail.com>
 * @copyright Copyright (c) 2023 Riikka Kalliomäki
 * @license http://opensource.org/licenses/mit-license.php MIT License
 * @implements TaskInterface<Day4Input>
 */
class Day4Part2Task extends AbstractDay4Task
{
    public static function createTask(): static
    {
        return new self();
    }

    public function solveTask(TaskInputInterface $input): string
    {
        $totalCards = array_fill(0, \count($input->scratchCards), 1);

        foreach ($input->scratchCards as $index => $card) {
            $hits = \count(array_intersect($card->winningNumbers, $card->cardNumbers));

            for ($i = 1; $i <= $hits && isset($totalCards[$index + $i]); $i++) {
                $totalCards[$index + $i] += $totalCards[$index];
            }
        }

        return (string) array_sum($totalCards);
    }
}
