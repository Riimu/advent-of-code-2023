<?php

declare(strict_types=1);

namespace Riimu\AdventOfCode2023\Task\Day7;

/**
 * @author Riikka Kalliomäki <riikka.kalliomaki@gmail.com>
 * @copyright Copyright (c) 2023 Riikka Kalliomäki
 * @license http://opensource.org/licenses/mit-license.php MIT License
 */
class Day7Part2Task extends AbstractDay7Task
{
    protected function solve(Day7Input $input): int
    {
        $values = [];

        foreach ($input->hands as $key => $hand) {
            $values[$key] = sprintf('%d%s', $this->calculateStrength($hand->hand), strtr($hand->hand, [
                'T' => 'A',
                'J' => '1',
                'Q' => 'C',
                'K' => 'D',
                'A' => 'E',
            ]));
        }

        $order = array_keys($input->hands);
        usort($order, static fn(int $a, int $b): int => strcasecmp($values[$a], $values[$b]));

        $total = 0;
        $rank = 1;

        foreach ($order as $key) {
            $total += $input->hands[$key]->bid * $rank++;
        }

        return $total;
    }

    private function calculateStrength(string $hand): int
    {
        $counts = array_count_values(str_split($hand));
        $jokers = $counts['J'] ?? 0;
        unset($counts['J']);
        rsort($counts);

        if ($counts === []) {
            return 7;
        }

        $counts[0] += $jokers;

        return match ($counts) {
            [5] => 7,
            [4, 1] => 6,
            [3, 2] => 5,
            [3, 1, 1] => 4,
            [2, 2, 1] => 3,
            [2, 1, 1, 1] => 2,
            default => 1,
        };
    }
}
