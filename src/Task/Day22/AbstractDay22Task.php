<?php

declare(strict_types=1);

namespace Riimu\AdventOfCode2023\Task\Day22;

use Riimu\AdventOfCode2023\TaskInputInterface;
use Riimu\AdventOfCode2023\TaskInterface;
use Riimu\AdventOfCode2023\Utility\Parse;

/**
 * @author Riikka Kalliomäki <riikka.kalliomaki@gmail.com>
 * @copyright Copyright (c) 2023 Riikka Kalliomäki
 * @license http://opensource.org/licenses/mit-license.php MIT License
 */
abstract class AbstractDay22Task implements TaskInterface
{
    final public function __construct() {}

    public static function createTask(): static
    {
        return new static();
    }

    public function parseInput(string $input): Day22Input
    {
        $bricks = [];

        foreach (Parse::lines($input) as $line) {
            [$startX, $startY, $startZ, $endX, $endY, $endZ] = Parse::ints($line);
            $bricks[] = new Brick(
                new BrickCoordinate($startX, $startY, $startZ),
                new BrickCoordinate($endX, $endY, $endZ)
            );
        }

        return new Day22Input($bricks);
    }

    public function solveTask(TaskInputInterface $input): string
    {
        if (!$input instanceof Day22Input) {
            throw new \InvalidArgumentException(sprintf("Unexpected input type '%s'", get_debug_type($input)));
        }

        return (string) $this->solve($input);
    }

    abstract protected function solve(Day22Input $input): int;
}
