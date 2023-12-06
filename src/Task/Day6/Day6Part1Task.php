<?php

declare(strict_types=1);

namespace Riimu\AdventOfCode2023\Task\Day6;

use Riimu\AdventOfCode2023\TaskInputInterface;
use Riimu\AdventOfCode2023\TaskInterface;

/**
 * @author Riikka Kalliomäki <riikka.kalliomaki@gmail.com>
 * @copyright Copyright (c) 2023 Riikka Kalliomäki
 * @license http://opensource.org/licenses/mit-license.php MIT License
 * @implements TaskInterface<Day6Input>
 */
class Day6Part1Task extends AbstractDay6Task
{
    public function solveTask(TaskInputInterface $input): string
    {
        $winCounts = [];

        foreach (array_keys($input->times) as $game) {
            $time = $input->times[$game];
            $distance = $input->distances[$game];

            $winCounts[] = self::calculateMaximum($time, $distance) - self::calculateMinimum($time, $distance) + 1;
        }

        return (string) array_product($winCounts);
    }

}
