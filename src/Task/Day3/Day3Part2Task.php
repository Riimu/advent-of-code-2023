<?php

declare(strict_types=1);

namespace Riimu\AdventOfCode2023\Task\Day3;

/**
 * @author Riikka Kalliomäki <riikka.kalliomaki@gmail.com>
 * @copyright Copyright (c) 2023 Riikka Kalliomäki
 * @license http://opensource.org/licenses/mit-license.php MIT License
 */
class Day3Part2Task extends AbstractDay3Task
{
    protected function solve(Day3Input $input): int
    {
        $partNumbers = [];

        foreach ($input->map as $y => $row) {
            foreach ($row as $x => $character) {
                $number = $this->getNumberAt($input, $x, $y);

                if ($number === null) {
                    continue;
                }

                $symbol = $this->getSymbolAt($input, $number, $x, $y);

                if ($symbol !== null) {
                    $partNumbers[$symbol][] = $number;
                }
            }
        }

        $gearRatios = [];

        foreach ($partNumbers as $key => $numbers) {
            if ($key[0] === '*' && \count($numbers) === 2) {
                $gearRatios[] = (int) array_product($numbers);
            }
        }

        return array_sum($gearRatios);
    }
}
