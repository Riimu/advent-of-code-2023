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
    protected function countCards(string $hand): array
    {
        $counts = array_count_values(str_split($hand));
        $jokers = $counts['J'] ?? 0;
        unset($counts['J']);

        if ($counts === []) {
            return [5];
        }

        rsort($counts);
        $counts[0] += $jokers;

        return $counts;
    }

    protected function getSortValue(string $hand): string
    {
        return strtr($hand, [
            'T' => 'A',
            'J' => '1',
            'Q' => 'C',
            'K' => 'D',
            'A' => 'E',
        ]);
    }



}
