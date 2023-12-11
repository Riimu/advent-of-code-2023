<?php

declare(strict_types=1);

namespace Riimu\AdventOfCode2023\Task\Day11;

use Riimu\AdventOfCode2023\TaskInputInterface;
use Riimu\AdventOfCode2023\TaskInterface;
use Riimu\AdventOfCode2023\Utility\Parse;

/**
 * @author Riikka Kalliomäki <riikka.kalliomaki@gmail.com>
 * @copyright Copyright (c) 2023 Riikka Kalliomäki
 * @license http://opensource.org/licenses/mit-license.php MIT License
 */
abstract class AbstractDay11Task implements TaskInterface
{
    final public function __construct() {}

    public static function createTask(): static
    {
        return new static();
    }

    public function parseInput(string $input): Day11Input
    {
        return new Day11Input(array_map(str_split(...), Parse::lines($input)));
    }

    public function solveTask(TaskInputInterface $input): string
    {
        if (!$input instanceof Day11Input) {
            throw new \InvalidArgumentException(sprintf("Unexpected input type '%s'", get_debug_type($input)));
        }

        return (string) $this->solve($input);
    }

    abstract protected function solve(Day11Input $input): int;

    /**
     * @param array<int, array<int, string>> $map
     * @param int $expansion
     * @return array<int, int>
     */
    protected function calculateLengths(array $map, int $expansion): array
    {
        $columnLengths = array_fill(0, \count($map[0]), $expansion);
        $rowLengths = array_fill(0, \count($map), $expansion);
        $stars = [];

        foreach ($map as $y => $row) {
            foreach ($row as $x => $node) {
                if ($node === '#') {
                    $stars[] = [$x, $y];
                    $columnLengths[$x] = 1;
                    $rowLengths[$y] = 1;
                }
            }
        }

        $count = \count($stars);
        $lengths = [];

        foreach ($stars as $index => [$x, $y]) {
            for ($i = $index + 1; $i < $count; $i++) {
                $lengths[] =
                    array_sum(\array_slice($columnLengths, min($x, $stars[$i][0]), abs($stars[$i][0] - $x))) +
                    array_sum(\array_slice($rowLengths, min($y, $stars[$i][1]), abs($stars[$i][1] - $y)));
            }
        }

        return $lengths;
    }
}
