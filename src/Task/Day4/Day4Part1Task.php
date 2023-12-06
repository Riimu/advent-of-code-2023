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
class Day4Part1Task extends AbstractDay4Task
{
    public static function createTask(): static
    {
        return new self();
    }

    public function solveTask(TaskInputInterface $input): string
    {
        $cardPoints = [];

        foreach ($input->scratchCards as $card) {
            $hits = \count(array_intersect($card->winningNumbers, $card->cardNumbers));
            $cardPoints[] = $hits > 0 ? 2 ** ($hits - 1) : 0;
        }

        return (string) array_sum($cardPoints);
    }
}
