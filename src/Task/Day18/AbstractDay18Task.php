<?php

declare(strict_types=1);

namespace Riimu\AdventOfCode2023\Task\Day18;

use Riimu\AdventOfCode2023\TaskInputInterface;
use Riimu\AdventOfCode2023\TaskInterface;
use Riimu\AdventOfCode2023\Utility\Direction;
use Riimu\AdventOfCode2023\Utility\Parse;

/**
 * @author Riikka Kalliomäki <riikka.kalliomaki@gmail.com>
 * @copyright Copyright (c) 2023 Riikka Kalliomäki
 * @license http://opensource.org/licenses/mit-license.php MIT License
 */
abstract class AbstractDay18Task implements TaskInterface
{
    final public function __construct() {}

    public static function createTask(): static
    {
        return new static();
    }

    public function parseInput(string $input): Day18Input
    {
        $instructions = [];

        foreach (Parse::lines($input) as $line) {
            if (!preg_match('/([RLUD])\s+(\d+)\s+\(#([0-9A-Fa-f]{6})\)/', $line, $match)) {
                throw new \RuntimeException("Unexpected line in input '$line'");
            }

            $instructions[] = new Instruction(
                Direction::fromString($match[1]),
                Parse::int($match[2]),
                Parse::hexadecimal($match[3])
            );
        }

        return new Day18Input($instructions);
    }

    public function solveTask(TaskInputInterface $input): string
    {
        if (!$input instanceof Day18Input) {
            throw new \InvalidArgumentException(sprintf("Unexpected input type '%s'", get_debug_type($input)));
        }

        return (string) $this->solve($input);
    }

    abstract protected function solve(Day18Input $input): int;
}
