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
        $steps = 0;
        $nodes = [];

        foreach (array_keys($input->nodes) as $key) {
            if ($key[2] === 'A') {
                $nodes[] = $key;
            }
        }

        while (!$this->isFinished($nodes)) {
            foreach (str_split($input->instructions) as $step) {
                foreach ($nodes as $key => $node) {
                    $nodes[$key] = $step === 'L'
                        ? $input->nodes[$node]->left
                        : $input->nodes[$node]->right;
                }

                $steps++;

                if ($this->isFinished($nodes)) {
                    break;
                }
            }
        }

        return $steps;
    }

    private function isFinished(array $nodes): bool
    {
        foreach ($nodes as $node) {
            if ($node[2] !== 'Z') {
                return false;
            }
        }

        return true;
    }
}
