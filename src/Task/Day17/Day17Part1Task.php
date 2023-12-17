<?php

declare(strict_types=1);

namespace Riimu\AdventOfCode2023\Task\Day17;

use Riimu\AdventOfCode2023\Utility\Direction;

/**
 * @author Riikka Kalliomäki <riikka.kalliomaki@gmail.com>
 * @copyright Copyright (c) 2023 Riikka Kalliomäki
 * @license http://opensource.org/licenses/mit-license.php MIT License
 */
class Day17Part1Task extends AbstractDay17Task
{
    protected function solve(Day17Input $input): int
    {
        $height = \count($input->map);
        $width = \count($input->map[0]);

        $queue = new TravelPriorityQueue();
        $queue->insert(new TravelNode(0, 0, 0, Direction::RIGHT, 0), 0);

        $minimumLossMap = [];

        while (true) {
            $node = $queue->extract();

            if (!$node instanceof TravelNode) {
                throw new \UnexpectedValueException('Unexpected node value: ' . get_debug_type($node));
            }

            foreach ($this->getDirections($node) as $direction) {
                [$x, $y] = $direction->moveCoordinate($node->x, $node->y);

                if (isset($input->map[$y][$x])) {
                    $steps = $direction === $node->direction ? $node->steps + 1 : 1;
                    $heatLoss = $node->heatLoss + $input->map[$y][$x];
                    $lossMapKey = sprintf('%d-%d-%d-%d', $x, $y, $direction->value, $steps);

                    if (isset($minimumLossMap[$lossMapKey]) && $heatLoss >= $minimumLossMap[$lossMapKey]) {
                        continue;
                    }

                    $minimumLossMap[$lossMapKey] = $heatLoss;
                    $distance = ($width - $x - 1) + ($height - $y - 1);

                    if ($this->isFinished($node, $distance)) {
                        return $heatLoss;
                    }

                    $queue->insert(new TravelNode($x, $y, $heatLoss, $direction, $steps), $heatLoss + $distance);
                }
            }
        }
    }

    /**
     * @param TravelNode $node
     * @return array<int, Direction>
     */
    private function getDirections(TravelNode $node): array
    {
        return $node->steps === 3
            ? [$node->direction->turnLeft(), $node->direction->turnRight()]
            : [$node->direction, $node->direction->turnLeft(), $node->direction->turnRight()];
    }

    private function isFinished(TravelNode $node, int $distance): bool
    {
        return $distance === 0;
    }
}
