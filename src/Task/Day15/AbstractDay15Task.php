<?php

declare(strict_types=1);

namespace Riimu\AdventOfCode2023\Task\Day15;

use Riimu\AdventOfCode2023\TaskInputInterface;
use Riimu\AdventOfCode2023\TaskInterface;

/**
 * @author Riikka Kalliomäki <riikka.kalliomaki@gmail.com>
 * @copyright Copyright (c) 2023 Riikka Kalliomäki
 * @license http://opensource.org/licenses/mit-license.php MIT License
 */
abstract class AbstractDay15Task implements TaskInterface
{
    final public function __construct() {}

    public static function createTask(): static
    {
        return new static();
    }

    public function parseInput(string $input): Day15Input
    {
        return new Day15Input(array_map(trim(...), explode(',', $input)));
    }

    public function solveTask(TaskInputInterface $input): string
    {
        if (!$input instanceof Day15Input) {
            throw new \InvalidArgumentException(sprintf("Unexpected input type '%s'", get_debug_type($input)));
        }

        return (string) $this->solve($input);
    }

    abstract protected function solve(Day15Input $input): int;
}
