<?php

declare(strict_types=1);

namespace Riimu\AdventOfCode2023\Task\Day8;

/**
 * @author Riikka Kalliomäki <riikka.kalliomaki@gmail.com>
 * @copyright Copyright (c) 2023 Riikka Kalliomäki
 * @license http://opensource.org/licenses/mit-license.php MIT License
 */
class Day8Part2Task extends AbstractDay8Task
{
    protected function solve(Day8Input $input): int
    {
        $stepsToExit = [];
        $length = \strlen($input->instructions);

        foreach (array_keys($input->nodes) as $node) {
            if ($node[2] === 'A') {
                $steps = 0;

                do {
                    $node = $input->instructions[$steps++ % $length] === 'L'
                        ? $input->nodes[$node]->left
                        : $input->nodes[$node]->right;
                } while ($node[2] !== 'Z');

                $stepsToExit[] = $steps;
            }
        }

        $maxFactors = [];

        foreach ($stepsToExit as $steps) {
            foreach ($this->getFactors($steps) as $factor => $count) {
                $maxFactors[$factor] = max($count, $maxFactors[$factor] ?? 0);
            }
        }

        $total = 1;

        foreach ($maxFactors as $factor => $count) {
            $total = $total * $factor ** $count;
        }

        return $total;
    }

    /**
     * @param int $number
     * @return array<int, int>
     */
    private function getFactors(int $number): array
    {
        $factors = [];

        while (true) {
            if ($number % 2 === 0) {
                $factors[2] = ($factors[2] ?? 0) + 1;
                $number /= 2;
                continue;
            }

            $root = sqrt($number);

            for ($i = 3; $i < $root; $i += 2) {
                if ($number % $i === 0) {
                    $factors[$i] = ($factors[$i] ?? 0) + 1;
                    $number /= $i;
                    continue 2;
                }
            }

            break;
        }

        $factors[$number] = 1;
        return $factors;
    }
}
