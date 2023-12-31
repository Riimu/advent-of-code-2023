<?php

declare(strict_types=1);

namespace Riimu\AdventOfCode2023\Task\Day17;

use Riimu\AdventOfCode2023\TaskInputInterface;
use Riimu\AdventOfCode2023\TaskInterface;
use Riimu\AdventOfCode2023\Utility\Direction;
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

    protected function solve(Day17Input $input): int
    {
        $height = \count($input->map);
        $width = \count($input->map[0]);

        $queue = new TravelPriorityQueue();

        $distance = $width + $height - 2;
        $queue->insert(new TravelNode(0, 0, 0, Direction::RIGHT, 0), $distance);
        $queue->insert(new TravelNode(0, 0, 0, Direction::DOWN, 0), $distance);

        $visitedNodes = new VisitedNodeCache();

        while (true) {
            $node = $queue->extract();

            if (!$node instanceof TravelNode) {
                throw new \UnexpectedValueException('Unexpected node value: ' . get_debug_type($node));
            }

            foreach ($this->getDirections($node) as $direction) {
                [$x, $y] = $direction->moveCoordinates($node->x, $node->y);

                if (isset($input->map[$y][$x])) {
                    $newNode = new TravelNode(
                        $x,
                        $y,
                        $node->heatLoss + $input->map[$y][$x],
                        $direction,
                        $direction === $node->direction ? $node->steps + 1 : 1
                    );

                    if ($this->isVisited($newNode, $visitedNodes)) {
                        continue;
                    }

                    $distance = ($width - $x - 1) + ($height - $y - 1);

                    if ($this->isFinished($newNode, $distance)) {
                        return $newNode->heatLoss;
                    }

                    $queue->insert($newNode, $newNode->heatLoss + $distance);
                }
            }
        }
    }

    /**
     * @param TravelNode $node
     * @return array<int, Direction>
     */
    abstract protected function getDirections(TravelNode $node): array;

    abstract protected function isVisited(TravelNode $node, VisitedNodeCache $visitedNodes): bool;

    abstract protected function isFinished(TravelNode $node, int $distance): bool;
}
