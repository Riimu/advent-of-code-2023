<?php

declare(strict_types=1);

namespace Riimu\AdventOfCode2023\Task\Day5;

use Riimu\AdventOfCode2023\TaskInputInterface;
use Riimu\AdventOfCode2023\TaskInterface;

/**
 * @author Riikka Kalliomäki <riikka.kalliomaki@gmail.com>
 * @copyright Copyright (c) 2023 Riikka Kalliomäki
 * @license http://opensource.org/licenses/mit-license.php MIT License
 */
class Day5Part1Task extends AbstractDay5Task
{
    public function solve(Day5Input $input): int
    {
        $locations = [];

        foreach ($input->seeds as $number) {
            foreach (self::INPUT_MAPS as $name) {
                foreach ($input->maps[$name] as $mapping) {
                    if ($number >= $mapping->sourceStart && $number < $mapping->sourceStart + $mapping->length) {
                        $number = $mapping->destinationStart + ($number - $mapping->sourceStart);
                        continue 2;
                    }
                }
            }

            $locations[] = $number;
        }

        return min($locations);
    }
}
