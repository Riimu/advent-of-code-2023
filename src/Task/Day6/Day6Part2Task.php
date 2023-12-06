<?php

declare(strict_types=1);

namespace Riimu\AdventOfCode2023\Task\Day6;

use Riimu\AdventOfCode2023\Parse;

/**
 * @author Riikka Kalliomäki <riikka.kalliomaki@gmail.com>
 * @copyright Copyright (c) 2023 Riikka Kalliomäki
 * @license http://opensource.org/licenses/mit-license.php MIT License
 */
class Day6Part2Task extends AbstractDay6Task
{
    protected function solve(Day6Input $input): int
    {
        $time = Parse::int(implode('', array_map(strval(...), $input->times)));
        $distance = Parse::int(implode('', array_map(strval(...), $input->distances)));

        return (self::calculateMaximum($time, $distance) - self::calculateMinimum($time, $distance) + 1);
    }
}
