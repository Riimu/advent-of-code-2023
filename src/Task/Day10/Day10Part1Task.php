<?php

declare(strict_types=1);

namespace Riimu\AdventOfCode2023\Task\Day10;

/**
 * @author Riikka Kalliomäki <riikka.kalliomaki@gmail.com>
 * @copyright Copyright (c) 2023 Riikka Kalliomäki
 * @license http://opensource.org/licenses/mit-license.php MIT License
 */
class Day10Part1Task extends AbstractDay10Task
{
    protected function solve(Day10Input $input): int
    {
        $startX = 0;
        $startY = 0;

        foreach ($input->map as $y => $row) {
            foreach ($row as $x => $node) {
                if ($node === 'S') {
                    $startX = $x;
                    $startY = $y;

                    break 2;
                }
            }
        }

        $routes = [];

        foreach (Direction::cases() as $case) {
            $routes[] = $this->traverse($input->map, $startX, $startY, $case);
        }

        $distances = [];

        foreach ($routes as $route) {
            if (!\is_array($route)) {
                continue;
            }

            foreach ($route as [$x, $y, $distance]) {
                $key = sprintf('%d,%d', $x, $y);
                $distances[$key] = isset($distances[$key]) ? min($distances[$key], $distance) : $distance;
            }
        }

        return max($distances);
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
        return match ($map[$y][$x]) {
            'F' => $direction === Direction::LEFT ? Direction::DOWN : Direction::RIGHT,
            'L' => $direction === Direction::LEFT ? Direction::UP : Direction::RIGHT,
            '7' => $direction === Direction::RIGHT ? Direction::DOWN : Direction::LEFT,
            'J' => $direction === Direction::RIGHT ? Direction::UP : Direction::LEFT,
            default => $direction,
        };
    }
}
