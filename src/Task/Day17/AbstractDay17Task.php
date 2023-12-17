<?php

declare(strict_types=1);

namespace Riimu\AdventOfCode2023\Task\Day17;

use Riimu\AdventOfCode2023\TaskInputInterface;
use Riimu\AdventOfCode2023\TaskInterface;
use Riimu\AdventOfCode2023\Utility\Parse;

/**
 * @author Riikka Kalliomäki <riikka.kalliomaki@gmail.com>
 * @copyright Copyright (c) 2023 Riikka Kalliomäki
 * @license http://opensource.org/licenses/mit-license.php MIT License
 */
abstract class AbstractDay17Task implements TaskInterface
{
    final public function __construct() {}

    public static function createTask(): static
    {
        return new static();
    }

    public function parseInput(string $input): Day17Input
    {
        return new Day17Input(
            array_map(
                static fn(string $x): array => array_map(Parse::int(...), str_split($x)),
                Parse::lines($input)
            )
        );
    }

    public function solveTask(TaskInputInterface $input): string
    {
        if (!$input instanceof Day17Input) {
            throw new \InvalidArgumentException(sprintf("Unexpected input type '%s'", get_debug_type($input)));
        }

        return (string) $this->solve($input);
    }

    abstract protected function solve(Day17Input $input): int;
}
