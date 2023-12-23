<?php

declare(strict_types=1);

namespace Riimu\AdventOfCode2023\Task\Day23;

use Riimu\AdventOfCode2023\Utility\Direction;

/**
 * @author Riikka Kalliomäki <riikka.kalliomaki@gmail.com>
 * @copyright Copyright (c) 2023 Riikka Kalliomäki
 * @license http://opensource.org/licenses/mit-license.php MIT License
 */
class Day23Part1Task extends AbstractDay23Task
{
    protected function solve(Day23Input $input): int
    {
        $startX = 0;
        $startY = 0;
        $endX = 0;
        $endY = \count($input->map) - 1;

        foreach ($input->map[$startY] as $x => $node) {
            if ($node === Day23Input::NODE_SPACE) {
                $startX = $x;
                break;
            }
        }

        foreach ($input->map[$endY] as $x => $node) {
            if ($node === Day23Input::NODE_SPACE) {
                $endX = $x;
                break;
            }
        }

        $nodeQueue = [[$startX, $startY, 0, [$startY => [$startX => true]]]];
        $maxLength = 0;

        while ($nodeQueue !== []) {
            [$x, $y, $steps, $visited] = array_pop($nodeQueue);
            $steps++;

            foreach ($this->getNodeDirections($input->map[$y][$x]) as $direction) {
                [$newX, $newY] = $direction->moveCoordinates($x, $y);

                if ($newX === $endX && $newY === $endY) {
                    $maxLength = (int) max($steps, $maxLength);
                } elseif (isset($input->map[$newY][$newX]) &&
                    $input->map[$newY][$newX] !== Day23Input::NODE_WALL &&
                    !isset($visited[$newY][$newX])
                ) {
                    $newPath = $visited;
                    $newPath[$newY][$newX] = true;
                    $nodeQueue[] = [$newX, $newY, $steps, $newPath];
                }
            }
        }

        return $maxLength;
    }

    /**
     * @param string $node
     * @return array<int, Direction>
     */
    private function getNodeDirections(string $node): array
    {
        return match ($node) {
            Day23Input::NODE_SLOPE_LEFT => [Direction::LEFT],
            Day23Input::NODE_SLOPE_RIGHT => [Direction::RIGHT],
            Day23Input::NODE_SLOPE_UP => [Direction::UP],
            Day23Input::NODE_SLOPE_DOWN => [Direction::DOWN],
            default => Direction::cases(),
        };
    }
}
