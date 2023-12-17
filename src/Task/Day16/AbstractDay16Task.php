<?php

declare(strict_types=1);

namespace Riimu\AdventOfCode2023\Task\Day16;

use Riimu\AdventOfCode2023\TaskInputInterface;
use Riimu\AdventOfCode2023\TaskInterface;
use Riimu\AdventOfCode2023\Utility\Direction;
use Riimu\AdventOfCode2023\Utility\Parse;

/**
 * @author Riikka Kalliomäki <riikka.kalliomaki@gmail.com>
 * @copyright Copyright (c) 2023 Riikka Kalliomäki
 * @license http://opensource.org/licenses/mit-license.php MIT License
 */
abstract class AbstractDay16Task implements TaskInterface
{
    final public function __construct() {}

    public static function createTask(): static
    {
        return new static();
    }

    public function parseInput(string $input): Day16Input
    {
        return new Day16Input(array_map(str_split(...), Parse::lines($input)));
    }

    public function solveTask(TaskInputInterface $input): string
    {
        if (!$input instanceof Day16Input) {
            throw new \InvalidArgumentException(sprintf("Unexpected input type '%s'", get_debug_type($input)));
        }

        return (string) $this->solve($input);
    }

    abstract protected function solve(Day16Input $input): int;

    /**
     * @param array<int, array<int, string>> $map
     * @param int $startX
     * @param int $startY
     * @param Direction $startDirection
     * @param array<int, array<int, array<int, bool>>> $visitedExits
     * @return int
     */
    protected function countEnergized(array $map, int $startX, int $startY, Direction $startDirection, array &$visitedExits = []): int
    {
        $beams = [[$startX, $startY, $startDirection]];
        $movedDirections = [];

        do {
            $newBeams = [];

            foreach ($beams as [$x, $y, $direction]) {
                $mapNode = $map[$y][$x];

                $beamAlignment = match ($mapNode) {
                    Day16Input::NODE_FORWARD_MIRROR => $direction === Direction::LEFT || $direction === Direction::UP ? 0 : 1,
                    Day16Input::NODE_BACKWARD_MIRROR => $direction === Direction::LEFT || $direction === Direction::DOWN ? 0 : 1,
                    default => $direction === Direction::LEFT || $direction === Direction::RIGHT ? 0 : 1,
                };

                if (isset($movedDirections[$y][$x][$beamAlignment])) {
                    continue;
                }

                $movedDirections[$y][$x][$beamAlignment] = true;

                foreach ($this->moveBeam($mapNode, $x, $y, $direction) as [$newX, $newY, $newDirection]) {
                    if (!isset($map[$newY][$newX])) {
                        $exitDirection = $newDirection->turnAround();
                        [$exitX, $exitY] = $exitDirection->moveCoordinates($newX, $newY);
                        $visitedExits[$exitY][$exitX][$exitDirection->value] = true;

                        continue;
                    }

                    $newBeams[] = [$newX, $newY, $newDirection];
                }
            }

            $beams = $newBeams;
        } while ($beams !== []);

        return array_sum(array_map(\count(...), $movedDirections));
    }

    /**
     * @param string $mapNode
     * @param int $x
     * @param int $y
     * @param Direction $direction
     * @return array<int, array{0: int, 1: int, 2: Direction}>
     */
    protected function moveBeam(string $mapNode, int $x, int $y, Direction $direction): array
    {
        $directions = match ($mapNode) {
            Day16Input::NODE_FORWARD_MIRROR => match ($direction) {
                Direction::LEFT, Direction::RIGHT => [$direction->turnLeft()],
                default => [$direction->turnRight()],
            },
            Day16Input::NODE_BACKWARD_MIRROR => match ($direction) {
                Direction::LEFT, Direction::RIGHT => [$direction->turnRight()],
                default => [$direction->turnLeft()],
            },
            Day16Input::NODE_VERTICAL_SPLITTER => match ($direction) {
                Direction::LEFT, Direction::RIGHT => [Direction::UP, Direction::DOWN],
                default => [$direction],
            },
            Day16Input::NODE_HORIZONTAL_SPLITTER => match ($direction) {
                Direction::LEFT, Direction::RIGHT => [$direction],
                default => [Direction::LEFT, Direction::RIGHT],
            },
            default => [$direction],
        };

        $beams = [];

        foreach ($directions as $newDirection) {
            $beams[] = [...$newDirection->moveCoordinates($x, $y), $newDirection];
        }

        return $beams;
    }
}
