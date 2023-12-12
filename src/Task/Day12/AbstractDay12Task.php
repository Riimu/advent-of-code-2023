<?php

declare(strict_types=1);

namespace Riimu\AdventOfCode2023\Task\Day12;

use Riimu\AdventOfCode2023\TaskInputInterface;
use Riimu\AdventOfCode2023\TaskInterface;
use Riimu\AdventOfCode2023\Utility\Parse;

/**
 * @author Riikka Kalliomäki <riikka.kalliomaki@gmail.com>
 * @copyright Copyright (c) 2023 Riikka Kalliomäki
 * @license http://opensource.org/licenses/mit-license.php MIT License
 */
abstract class AbstractDay12Task implements TaskInterface
{
    /**
     * @var array<string, int>
     */
    private array $cache = [];

    final public function __construct() {}

    public static function createTask(): static
    {
        return new static();
    }

    public function parseInput(string $input): Day12Input
    {
        $records = [];

        foreach (Parse::lines($input) as $line) {
            [$condition, $groups] = explode(' ', $line);
            $records[] = new Record($condition, Parse::ints($groups));
        }

        return new Day12Input($records);
    }

    public function solveTask(TaskInputInterface $input): string
    {
        if (!$input instanceof Day12Input) {
            throw new \InvalidArgumentException(sprintf("Unexpected input type '%s'", get_debug_type($input)));
        }

        return (string) $this->solve($input);
    }

    abstract protected function solve(Day12Input $input): int;

    /**
     * @param string $condition
     * @param array<int, int> $groups
     * @return int
     */
    protected function tryArrangements(string $condition, array $groups): int
    {
        if ($groups === []) {
            return str_contains($condition, '#') ? 0 : 1;
        }

        $condition = trim($condition, '.');

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

            $condition = substr($condition, $position + 1);
        }

        $this->cache[$cacheKey] = $arrangements;

        return $arrangements;
    }
}
