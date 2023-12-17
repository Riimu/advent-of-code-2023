<?php

declare(strict_types=1);

namespace Riimu\AdventOfCode2023\Utility;

enum Direction: int
{
    case LEFT = 1;
    case RIGHT = 2;
    case UP = 3;
    case DOWN = 4;

    public function turnLeft(): self
    {
        return match ($this) {
            self::LEFT => self::DOWN,
            self::RIGHT => self::UP,
            self::UP => self::LEFT,
            self::DOWN => self::RIGHT,
        };
    }

    public function turnRight(): self
    {
        return match ($this) {
            self::LEFT => self::UP,
            self::RIGHT => self::DOWN,
            self::UP => self::RIGHT,
            self::DOWN => self::LEFT,
        };
    }

    /**
     * @param int $x
     * @param int $y
     * @return array{0: int, 1: int}
     */
    public function moveCoordinate(int $x, int $y): array
    {
        return match ($this) {
            self::LEFT => [$x - 1, $y],
            self::RIGHT => [$x + 1, $y],
            self::UP => [$x, $y - 1],
            self::DOWN => [$x, $y + 1],
        };
    }
}
