<?php

declare(strict_types=1);

namespace Riimu\AdventOfCode2023\Task\Day12;

/**
 * @author Riikka Kalliomäki <riikka.kalliomaki@gmail.com>
 * @copyright Copyright (c) 2023 Riikka Kalliomäki
 * @license http://opensource.org/licenses/mit-license.php MIT License
 */
class Day12Part2Task extends AbstractDay12Task
{
    /**
     * @var array<string, int>
     */
    private array $cache = [];

    protected function solve(Day12Input $input): int
    {
        $arrangements = [];

        foreach ($input->records as $record) {
            $arrangements[] = $this->tryArrangements(
                implode('?', array_fill(0, 5, $record->condition)),
                array_merge(...array_fill(0, 5, $record->groups))
            );
        }

        return array_sum($arrangements);
    }

    private function tryArrangements(string $condition, array $groups): int
    {
        $condition = trim($condition, '.');

        if ($groups === []) {
            return str_contains($condition, '#') ? 0 : 1;
        }

        if (\strlen($condition) < array_sum($groups) + \count($groups) - 1) {
            return 0;
        }

        $cacheKey = sprintf('%s %s', $condition, implode(',', $groups));

        if (\array_key_exists($cacheKey, $this->cache)) {
            return $this->cache[$cacheKey];
        }

        $arrangements = 0;
        $groupLength = array_shift($groups);
        $pattern = sprintf('/^([.?]*)[#?]{%d}($|[?.])/U', $groupLength);

        while (preg_match($pattern, $condition, $match) === 1) {
            $position = \strlen($match[1]);
            $arrangements += $this->tryArrangements(substr($condition, $position + $groupLength + 1), $groups);

            if ($condition[$position] === '#') {
                break;
            }

            $condition = substr_replace($condition, str_repeat('.', $position + 1), 0, $position + 1);
        }

        $this->cache[$cacheKey] = $arrangements;

        return $arrangements;
    }
}
