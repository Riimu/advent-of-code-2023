<?php

declare(strict_types=1);

namespace Riimu\AdventOfCode2023\Task\Day17;

/**
 * @author Riikka Kalliomäki <riikka.kalliomaki@gmail.com>
 * @copyright Copyright (c) 2023 Riikka Kalliomäki
 * @license http://opensource.org/licenses/mit-license.php MIT License
 */
class Day17Part2Task extends AbstractDay17Task
{
    protected function getDirections(TravelNode $node): array
    {
        if ($node->steps < 4) {
            return [$node->direction];
        }

        return $node->steps === 10
            ? [$node->direction->turnLeft(), $node->direction->turnRight()]
            : [$node->direction, $node->direction->turnLeft(), $node->direction->turnRight()];
    }

    protected function isVisited(TravelNode $node, VisitedNodeCache $visitedNodes): bool
    {
        if (isset($visitedNodes->nodes[$node->y][$node->x][$node->direction->value])) {
            foreach ($visitedNodes->nodes[$node->y][$node->x][$node->direction->value] as $steps => $heatLoss) {
                if ($heatLoss <= $node->heatLoss && (($steps > 3 && $steps <= $node->steps) || $steps === $node->steps)) {
                    return true;
                }
            }
        }

        $visitedNodes->nodes[$node->y][$node->x][$node->direction->value][$node->steps] = $node->heatLoss;

        return false;
    }

    protected function isFinished(TravelNode $node, int $distance): bool
    {
        if ($node->steps < 4) {
            return false;
        }

        return $distance === 0;
    }
}
