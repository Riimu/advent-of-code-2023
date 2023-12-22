<?php

declare(strict_types=1);

namespace Riimu\AdventOfCode2023\Task\Day22;

/**
 * @author Riikka Kalliomäki <riikka.kalliomaki@gmail.com>
 * @copyright Copyright (c) 2023 Riikka Kalliomäki
 * @license http://opensource.org/licenses/mit-license.php MIT License
 */
readonly class Brick
{
    public function __construct(
        public BrickCoordinate $start,
        public BrickCoordinate $end,
    ) {}

    public function fallTo(int $z): self
    {
        $fallHeight = $this->getBottom() - $z;

        return new Brick(
            new BrickCoordinate($this->start->x, $this->start->y, $this->start->z - $fallHeight),
            new BrickCoordinate($this->end->x, $this->end->y, $this->end->z - $fallHeight)
        );
    }

    public function getTop(): int
    {
        return max($this->start->z, $this->end->z);
    }

    public function getBottom(): int
    {
        return min($this->start->z, $this->end->z);
    }

    /**
     * @return iterable<BrickCoordinate>
     */
    public function iterateTop(): iterable
    {
        yield from match (true) {
            $this->start->z !== $this->end->z => [$this->start->z > $this->end->z ? $this->start : $this->end],
            $this->start->y !== $this->end->y => $this->iterateY(),
            default => $this->iterateX()
        };
    }

    /**
     * @return iterable<BrickCoordinate>
     */
    public function iterateBottom(): iterable
    {
        yield from match (true) {
            $this->start->z !== $this->end->z => [$this->start->z < $this->end->z ? $this->start : $this->end],
            $this->start->y !== $this->end->y => $this->iterateY(),
            default => $this->iterateX()
        };
    }

    /**
     * @return iterable<BrickCoordinate>
     */
    public function iterateX(): iterable
    {
        foreach (range($this->start->x, $this->end->x) as $x) {
            yield new BrickCoordinate($x, $this->start->y, $this->start->z);
        }
    }

    /**
     * @return iterable<BrickCoordinate>
     */
    public function iterateY(): iterable
    {
        foreach (range($this->start->y, $this->end->y) as $y) {
            yield new BrickCoordinate($this->start->x, $y, $this->start->z);
        }
    }
}
