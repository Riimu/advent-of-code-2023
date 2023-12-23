<?php

declare(strict_types=1);

namespace Riimu\AdventOfCode2023\Utility;

enum Direction: int
{
    case LEFT = 1;
    case RIGHT = 2;
    case UP = 3;
    case DOWN = 4;

    public static function fromString(string $string): self
    {
        return match ($string) {
            'L' => self::LEFT,
            'R' => self::RIGHT,
            'U' => self::UP,
            'D' => self::DOWN,
            default => throw new \ValueError("Unexpected direction string '$string'"),
        };
    }

    // Every now and then I get a little bit lonely. And you're never coming 'round
    public function turnAround(): self
    {
        return match ($this) {
            self::LEFT => self::RIGHT,
            self::RIGHT => self::LEFT,
            self::UP => self::DOWN,
            self::DOWN => self::UP,
        };
    }

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
     * @param int $distance
     * @return array{0: int, 1: int}
     */
    public function moveCoordinates(int $x, int $y, int $distance = 1): array
    {
        return match ($this) {
            self::LEFT => [$x - $distance, $y],
            self::RIGHT => [$x + $distance, $y],
            self::UP => [$x, $y - $distance],
            self::DOWN => [$x, $y + $distance],
        };
    }
}
