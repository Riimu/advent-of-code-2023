<?php

declare(strict_types=1);

namespace Riimu\AdventOfCode2023\Task\Day22;

/**
 * @author Riikka Kalliomäki <riikka.kalliomaki@gmail.com>
 * @copyright Copyright (c) 2023 Riikka Kalliomäki
 * @license http://opensource.org/licenses/mit-license.php MIT License
 */
class Brick
{
    public readonly BrickCoordinate $bottom;
    public readonly BrickCoordinate $top;
    public readonly bool $vertical;

    /** @var array<int, BrickCoordinate>|null */
    private array|null $allCoordinates;

    public function __construct(BrickCoordinate $start, BrickCoordinate $end)
    {
        if ($start->x > $end->x || $start->y > $end->y || $start->z > $end->z) {
            $this->bottom = $end;
            $this->top = $start;
        } else {
            $this->bottom = $start;
            $this->top = $end;
        }

        $this->vertical = $start->z !== $end->z;
        $this->allCoordinates = null;
    }

    public function fallTo(int $z): self
    {
        $fallHeight = $this->bottom->z - $z;

        return new Brick(
            new BrickCoordinate($this->bottom->x, $this->bottom->y, $this->bottom->z - $fallHeight),
            new BrickCoordinate($this->top->x, $this->top->y, $this->top->z - $fallHeight)
        );
    }

    /**
     * @return array<int, BrickCoordinate>
     */
    public function getCeilingCoordinates(): array
    {
        return $this->vertical ? [$this->top] : $this->getAllCoordinates();
    }

    /**
     * @return array<int, BrickCoordinate>
     */
    public function getFloorCoordinates(): array
    {
        return $this->vertical ? [$this->bottom] : $this->getAllCoordinates();
    }

    /**
     * @return array<int, BrickCoordinate>
     */
    private function getAllCoordinates(): array
    {
        return $this->allCoordinates ??= $this->createCoordinates();
    }

    /**
     * @return array<int, BrickCoordinate>
     */
    private function createCoordinates(): array
    {
        $coordinateList = [$this->bottom];

        if ($this->top->x > $this->bottom->x) {
            for ($x = $this->bottom->x + 1; $x < $this->top->x; $x++) {
                $coordinateList[] = new BrickCoordinate($x, $this->bottom->y, $this->bottom->z);
            }
        } elseif ($this->top->y > $this->bottom->y) {
            for ($y = $this->bottom->y + 1; $y < $this->top->y; $y++) {
                $coordinateList[] = new BrickCoordinate($this->bottom->x, $y, $this->bottom->z);
            }
        } elseif ($this->top->z > $this->bottom->z) {
            for ($z = $this->bottom->z + 1; $z < $this->top->z; $z++) {
                $coordinateList[] = new BrickCoordinate($this->bottom->x, $this->bottom->y, $z);
            }
        } else {
            return $coordinateList;
        }

        $coordinateList[] = $this->top;
        return $coordinateList;
    }
}
