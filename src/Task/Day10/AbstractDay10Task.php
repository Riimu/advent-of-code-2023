<?php

declare(strict_types=1);

namespace Riimu\AdventOfCode2023\Task\Day10;

use Riimu\AdventOfCode2023\TaskInputInterface;
use Riimu\AdventOfCode2023\TaskInterface;
use Riimu\AdventOfCode2023\Utility\Direction;
use Riimu\AdventOfCode2023\Utility\Parse;

/**
 * @author Riikka Kalliomäki <riikka.kalliomaki@gmail.com>
 * @copyright Copyright (c) 2023 Riikka Kalliomäki
 * @license http://opensource.org/licenses/mit-license.php MIT License
 */
abstract class AbstractDay10Task implements TaskInterface
{
    final public function __construct() {}

    public static function createTask(): static
    {
        return new static();
    }

    public function parseInput(string $input): Day10Input
    {
        return new Day10Input(array_map(str_split(...), Parse::lines($input)));
    }

    public function solveTask(TaskInputInterface $input): string
    {
        if (!$input instanceof Day10Input) {
            throw new \InvalidArgumentException(sprintf("Unexpected input type '%s'", get_debug_type($input)));
        }

        return (string) $this->solve($input);
    }

    abstract protected function solve(Day10Input $input): int;

    /**
     * @param array<int, array<int, string>> $map
     * @return array<int, array<int, array<int, int>>>
     */
    protected function findValidPipes(array $map): array
    {
        [$startX, $startY] = $this->find($map, 'S');
        $pipes = [];

        foreach (Direction::cases() as $direction) {
            [$x, $y] = $direction->moveCoordinates($startX, $startY);

            if ($this->isValidDirection($map, $x, $y, $direction)) {
                $pipes[] = $this->traverse($map, $startX, $startY, $direction);
            }
        }

        return $pipes;
    }

    /**
     * @param array<int, array<int, string>> $map
     * @param string $search
     * @return array<int, int>
     */
    protected function find(array $map, string $search): array
    {
        foreach ($map as $y => $row) {
            foreach ($row as $x => $node) {
                if ($node === $search) {
                    return [$x, $y];
                }
            }
        }

        return [0, 0];
    }

    /**
     * @param array<int, array<int, string>> $map
     * @param int $x
     * @param int $y
     * @param Direction $direction
     * @return array<int, array<int, int>>
     */
    protected function traverse(array $map, int $x, int $y, Direction $direction): array
    {
        $startX = $x;
        $startY = $y;
        $route = [];

        do {
            $route[] = [$x, $y];
            [$x, $y] = $direction->moveCoordinates($x, $y);
            $direction = $this->getNextDirection($map, $x, $y, $direction);
        } while ($x !== $startX || $y !== $startY);

        return $route;
    }

    /**
     * @param array<int, array<int, string>> $map
     * @param int $x
     * @param int $y
     * @param Direction $direction
     * @return bool
     */
    protected function isValidDirection(array $map, int $x, int $y, Direction $direction): bool
    {
        if (!isset($map[$y][$x])) {
            return false;
        }

        if ($map[$y][$x] === 'S') {
            return true;
        }

        return match($direction) {
            Direction::LEFT => \in_array($map[$y][$x], ['F', 'L', '-'], true),
            Direction::RIGHT => \in_array($map[$y][$x], ['7', 'J', '-'], true),
            Direction::UP => \in_array($map[$y][$x], ['7', 'F', '|'], true),
            Direction::DOWN => \in_array($map[$y][$x], ['L', 'J', '|'], true),
        };
    }

    /**
     * @param array<int, array<int, string>> $map
     * @param int $x
     * @param int $y
     * @param Direction $direction
     * @return Direction
     */
    protected function getNextDirection(array $map, int $x, int $y, Direction $direction): Direction
    {
        if ($map[$y][$x] === 'S') {
            foreach (Direction::cases() as $newDirection) {
                [$newX, $newY] = $newDirection->moveCoordinates($x, $y);

                if ($direction !== $newDirection->turnAround() &&
                    $this->isValidDirection($map, $newX, $newY, $newDirection)
                ) {
                    return $newDirection;
                }
            }
        }

        return match ($map[$y][$x]) {
            'F' => $direction === Direction::LEFT ? Direction::DOWN : Direction::RIGHT,
            'L' => $direction === Direction::LEFT ? Direction::UP : Direction::RIGHT,
            '7' => $direction === Direction::RIGHT ? Direction::DOWN : Direction::LEFT,
            'J' => $direction === Direction::RIGHT ? Direction::UP : Direction::LEFT,
            default => $direction,
        };
    }
}
