<?php

declare(strict_types=1);

namespace Riimu\AdventOfCode2023\Task\Day21;

use Riimu\AdventOfCode2023\TaskInputInterface;
use Riimu\AdventOfCode2023\TaskInterface;
use Riimu\AdventOfCode2023\Utility\Direction;
use Riimu\AdventOfCode2023\Utility\Parse;

/**
 * @author Riikka Kalliomäki <riikka.kalliomaki@gmail.com>
 * @copyright Copyright (c) 2023 Riikka Kalliomäki
 * @license http://opensource.org/licenses/mit-license.php MIT License
 */
abstract class AbstractDay21Task implements TaskInterface
{
    final public function __construct() {}

    public static function createTask(): static
    {
        return new static();
    }

    public function parseInput(string $input): Day21Input
    {
        return new Day21Input(array_map(str_split(...), Parse::lines($input)));
    }

    public function solveTask(TaskInputInterface $input): string
    {
        if (!$input instanceof Day21Input) {
            throw new \InvalidArgumentException(sprintf("Unexpected input type '%s'", get_debug_type($input)));
        }

        return (string) $this->solve($input);
    }

    abstract protected function solve(Day21Input $input): int;

    /**
     * @param array<int, array<int, string>> $map
     * @param string $symbol
     * @return array{0: int, 1: int}
     */
    protected function findSymbol(array $map, string $symbol): array
    {
        foreach ($map as $y => $row) {
            foreach ($row as $x => $node) {
                if ($node === $symbol) {
                    return [$x, $y];
                }
            }
        }

        return [0, 0];
    }

    /**
     * @param array<int, array<int, string>> $map
     * @param int $startX
     * @param int $startY
     * @return array<int, array<int, int|null>>
     */
    protected function countStepsFrom(array $map, int $startX, int $startY): array
    {
        $stepsFromStart = array_fill(0, \count($map), array_fill(0, \count($map[0]), null));
        $stepsFromStart[$startY][$startX] = 0;

        /** @var \SplQueue<array{0: int, 1: int, 2: int}> $stepsQueue */
        $stepsQueue = new \SplQueue();
        $stepsQueue->enqueue([$startX, $startY, 0]);

        while (!$stepsQueue->isEmpty()) {
            [$x, $y, $steps] = $stepsQueue->dequeue();
            $steps++;

            foreach (Direction::cases() as $direction) {
                [$newX, $newY] = $direction->moveCoordinates($x, $y);

                if (isset($map[$newY][$newX]) && $map[$newY][$newX] !== Day21Input::NODE_WALL && !isset($stepsFromStart[$newY][$newX])) {
                    $stepsFromStart[$newY][$newX] = $steps;
                    $stepsQueue->enqueue([$newX, $newY, $steps]);
                }
            }
        }

        return $stepsFromStart;
    }

    /**
     * @param array<int, array<int, int|null>> $stepCounts
     * @param int $steps
     * @return int
     */
    protected function countReachable(array $stepCounts, int $steps): int
    {
        $reachable = 0;
        $modulo = $steps % 2;

        foreach ($stepCounts as $row) {
            foreach ($row as $count) {
                if ($count !== null && $count <= $steps && $count % 2 === $modulo) {
                    $reachable++;
                }
            }
        }

        return $reachable;
    }
}
