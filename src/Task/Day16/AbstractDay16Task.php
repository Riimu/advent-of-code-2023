<?php

declare(strict_types=1);

namespace Riimu\AdventOfCode2023\Task\Day16;

use Riimu\AdventOfCode2023\TaskInputInterface;
use Riimu\AdventOfCode2023\TaskInterface;
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
     * @param int $x
     * @param int $y
     * @param Direction $direction
     * @return array<int, array{0: int, 1: int, 2: Direction}>
     */
    protected function moveBeam(array $map, int $x, int $y, Direction $direction): array
    {
        return match ($map[$y][$x]) {
            Day16Input::NODE_FORWARD_MIRROR => match ($direction) {
                Direction::LEFT => $this->moveDirections($map, $x, $y, [Direction::DOWN]),
                Direction::RIGHT => $this->moveDirections($map, $x, $y, [Direction::UP]),
                Direction::UP => $this->moveDirections($map, $x, $y, [Direction::RIGHT]),
                Direction::DOWN => $this->moveDirections($map, $x, $y, [Direction::LEFT]),
            },
            Day16Input::NODE_BACKWARD_MIRROR => match ($direction) {
                Direction::LEFT => $this->moveDirections($map, $x, $y, [Direction::UP]),
                Direction::RIGHT => $this->moveDirections($map, $x, $y, [Direction::DOWN]),
                Direction::UP => $this->moveDirections($map, $x, $y, [Direction::LEFT]),
                Direction::DOWN => $this->moveDirections($map, $x, $y, [Direction::RIGHT]),
            },
            Day16Input::NODE_VERTICAL_SPLITTER => match ($direction) {
                Direction::LEFT, Direction::RIGHT => $this->moveDirections($map, $x, $y, [Direction::UP, Direction::DOWN]),
                Direction::UP, Direction::DOWN => $this->moveDirections($map, $x, $y, [$direction]),
            },
            Day16Input::NODE_HORIZONTAL_SPLITTER => match ($direction) {
                Direction::LEFT, Direction::RIGHT => $this->moveDirections($map, $x, $y, [$direction]),
                Direction::UP, Direction::DOWN => $this->moveDirections($map, $x, $y, [Direction::LEFT, Direction::RIGHT]),
            },
            default => $this->moveDirections($map, $x, $y, [$direction]),
        };
    }

    /**
     * @param array<int, array<int, string>> $map
     * @param int $x
     * @param int $y
     * @param array<int, Direction> $directions
     * @return array<int, array{0: int, 1: int, 2: Direction}>
     */
    protected function moveDirections(array $map, int $x, int $y, array $directions): array
    {
        $beams = [];

        foreach ($directions as $direction) {
            [$newX, $newY] = match($direction) {
                Direction::LEFT => [$x - 1, $y],
                Direction::RIGHT => [$x + 1, $y],
                Direction::UP => [$x, $y - 1],
                Direction::DOWN => [$x, $y + 1],
            };

            if (isset($map[$newY][$newX])) {
                $beams[] = [$newX, $newY, $direction];
            }
        }

        return $beams;
    }
}
