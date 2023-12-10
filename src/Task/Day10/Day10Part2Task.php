<?php

declare(strict_types=1);

namespace Riimu\AdventOfCode2023\Task\Day10;

/**
 * @author Riikka Kalliomäki <riikka.kalliomaki@gmail.com>
 * @copyright Copyright (c) 2023 Riikka Kalliomäki
 * @license http://opensource.org/licenses/mit-license.php MIT License
 */
class Day10Part2Task extends AbstractDay10Task
{
    protected function solve(Day10Input $input): int
    {
        [$startX, $startY] = $this->find($input->map, 'S');

        $route = [];

        foreach (Direction::cases() as $case) {
            $attempt = $this->traverse($input->map, $startX, $startY, $case);

            if (\is_array($attempt)) {
                $route = $attempt;
                break;
            }
        }

        $fill = [];

        foreach ($input->map as $y => $row) {
            foreach ($row as $x => $node) {
                $fill[$y][$x] = true;
            }
        }

        foreach ($route as [$x, $y]) {
            $fill[$y][$x] = null;
        }

        $map = $input->map;

        foreach ($map as $y => $row) {
            foreach ($row as $x => $node) {
                if ($fill[$y][$x]) {
                    $map[$y][$x] = '.';
                }
            }
        }

        [$topLeftX, $topLeftY] = $this->find($map, 'F');

        if ($startY < $topLeftY) {
            $topLeftX = $startX;
            $topLeftY = $startY;
        }

        $x = $topLeftX;
        $y = $topLeftY;
        $direction = Direction::RIGHT;

        do {
            [$x, $y] = $this->moveDirection($x, $y, $direction);

            if ($direction === Direction::RIGHT) {
                for ($nextY = $y + 1; $fill[$nextY][$x]; $nextY++) {
                    $fill[$nextY][$x] = false;
                }
            }

            $direction = $this->getNextDirection($map, $x, $y, $direction);

            if ($direction === Direction::RIGHT) {
                for ($nextY = $y + 1; $fill[$nextY][$x]; $nextY++) {
                    $fill[$nextY][$x] = false;
                }
            }
        } while ($x !== $topLeftX || $y !== $topLeftY);

        return array_sum(array_map(
            static fn(array $x): int => \count(array_keys($x, false, true)),
            $fill
        ));
    }

    private function find(array $map, string $search): array
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

    private function traverse(array $map, int $x, int $y, Direction $direction): ?array
    {
        $distance = 0;
        $route = [];

        do {
            $route[] = [$x, $y, $distance];
            $distance++;

            [$x, $y] = $this->moveDirection($x, $y, $direction);

            if (!$this->isValidDirection($map, $x, $y, $direction)) {
                return null;
            }

            $direction = $this->getNextDirection($map, $x, $y, $direction);
        } while ($map[$y][$x] !== 'S');

        return $route;
    }

    private function moveDirection(int $x, int $y, Direction $direction): array
    {
        return match ($direction) {
            Direction::LEFT => [$x - 1, $y],
            Direction::RIGHT => [$x + 1, $y],
            Direction::UP => [$x, $y - 1],
            Direction::DOWN => [$x, $y + 1],
        };
    }

    private function isValidDirection(array $map, int $x, int $y, Direction $direction): bool
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

    private function getNextDirection(array $map, int $x, int $y, Direction $direction): Direction
    {
        if ($map[$y][$x] === 'S') {
            if ($direction !== Direction::RIGHT && $this->isValidDirection($map, $x - 1, $y, Direction::LEFT)) {
                return Direction::LEFT;
            }

            if ($direction !== Direction::LEFT && $this->isValidDirection($map, $x + 1, $y, Direction::RIGHT)) {
                return Direction::RIGHT;
            }

            if ($direction !== Direction::DOWN && $this->isValidDirection($map, $x, $y - 1, Direction::UP)) {
                return Direction::UP;
            }

            if ($direction !== Direction::UP && $this->isValidDirection($map, $x, $y + 1, Direction::DOWN)) {
                return Direction::DOWN;
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
