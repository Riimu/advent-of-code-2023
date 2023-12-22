<?php

declare(strict_types=1);

namespace Riimu\AdventOfCode2023\Task\Day22;

readonly class BrickCoordinate
{
    public function __construct(
        public int $x,
        public int $y,
        public int $z,
    ) {}
}
