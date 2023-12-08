<?php

declare(strict_types=1);

namespace Riimu\AdventOfCode2023\Task\Day8;

/**
 * @author Riikka Kalliomäki <riikka.kalliomaki@gmail.com>
 * @copyright Copyright (c) 2023 Riikka Kalliomäki
 * @license http://opensource.org/licenses/mit-license.php MIT License
 */
class Day8Part1Task extends AbstractDay8Task
{
    protected function solve(Day8Input $input): int
    {
        $node = 'AAA';
        $steps = 0;

        while ($node !== 'ZZZ') {
            foreach (str_split($input->instructions) as $step) {
                $node = $step === 'L'
                    ? $input->nodes[$node]->left
                    : $input->nodes[$node]->right;
                $steps++;

                if ($node === 'ZZZ') {
                    break;
                }
            }
        }

        return $steps;
    }
}
