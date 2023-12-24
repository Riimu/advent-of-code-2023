<?php

declare(strict_types=1);

namespace Riimu\AdventOfCode2023\Task\Day24;

use Riimu\AdventOfCode2023\TaskInputInterface;
use Riimu\AdventOfCode2023\TaskInterface;
use Riimu\AdventOfCode2023\Utility\Parse;

/**
 * @author Riikka Kalliomäki <riikka.kalliomaki@gmail.com>
 * @copyright Copyright (c) 2023 Riikka Kalliomäki
 * @license http://opensource.org/licenses/mit-license.php MIT License
 */
abstract class AbstractDay24Task implements TaskInterface
{
    final public function __construct() {}

    public static function createTask(): static
    {
        return new static();
    }

    public function parseInput(string $input): Day24Input
    {
        $hailstones = [];
        $velocities = [];

        foreach (Parse::lines($input) as $line) {
            [$x, $y, $z, $vx, $vy, $vz] = Parse::ints($line);

            $hailstones[] = [$x, $y, $z];
            $velocities[] = [$vx, $vy, $vz];
        }

        return new Day24Input($hailstones, $velocities);
    }

    public function solveTask(TaskInputInterface $input): string
    {
        if (!$input instanceof Day24Input) {
            throw new \InvalidArgumentException(sprintf("Unexpected input type '%s'", get_debug_type($input)));
        }

        return (string) $this->solve($input);
    }

    abstract protected function solve(Day24Input $input): int;
}
