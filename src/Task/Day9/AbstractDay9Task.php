<?php

declare(strict_types=1);

namespace Riimu\AdventOfCode2023\Task\Day9;

use Riimu\AdventOfCode2023\TaskInputInterface;
use Riimu\AdventOfCode2023\TaskInterface;
use Riimu\AdventOfCode2023\Utility\Parse;

/**
 * @author Riikka Kalliomäki <riikka.kalliomaki@gmail.com>
 * @copyright Copyright (c) 2023 Riikka Kalliomäki
 * @license http://opensource.org/licenses/mit-license.php MIT License
 */
abstract class AbstractDay9Task implements TaskInterface
{
    final public function __construct() {}

    public static function createTask(): static
    {
        return new static();
    }

    public function parseInput(string $input): Day9Input
    {
        return new Day9Input(array_map(Parse::ints(...), Parse::lines($input)));
    }

    public function solveTask(TaskInputInterface $input): string
    {
        if (!$input instanceof Day9Input) {
            throw new \InvalidArgumentException(sprintf("Unexpected input type '%s'", get_debug_type($input)));
        }

        return (string) $this->solve($input);
    }

    protected function solve(Day9Input $input): int
    {
        $extrapolated = [];

        foreach ($input->histories as $history) {
            $changes = [$history];

            while (array_unique($history) !== [0]) {
                $previous = $history;
                $history = [];

                $count = \count($previous);

                for ($i = 1; $i < $count; $i++) {
                    $history[] = $previous[$i] - $previous[$i - 1];
                }

                $changes[] = $history;
            }

            $extrapolated[] = static::calculateExtrapolatedValue($changes);
        }

        return array_sum($extrapolated);
    }

    /**
     * @param array<int, array<int, int>> $changes
     * @return int
     */
    abstract protected function calculateExtrapolatedValue(array $changes): int;
}
