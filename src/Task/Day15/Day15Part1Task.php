<?php

declare(strict_types=1);

namespace Riimu\AdventOfCode2023\Task\Day15;

/**
 * @author Riikka Kalliomäki <riikka.kalliomaki@gmail.com>
 * @copyright Copyright (c) 2023 Riikka Kalliomäki
 * @license http://opensource.org/licenses/mit-license.php MIT License
 */
class Day15Part1Task extends AbstractDay15Task
{
    protected function solve(Day15Input $input): int
    {
        $hashValues = [];

        foreach ($input->operations as $operation) {
            $currentValue = 0;
            $length = \strlen($operation);

            for ($i = 0; $i < $length; $i++) {
                $currentValue += \ord($operation[$i]);
                $currentValue *= 17;
                $currentValue %= 256;
            }

            $hashValues[] = $currentValue;
        }

        return array_sum($hashValues);
    }
}
