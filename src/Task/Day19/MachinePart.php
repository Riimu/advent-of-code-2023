<?php

declare(strict_types=1);

namespace Riimu\AdventOfCode2023\Task\Day19;

readonly class MachinePart
{
    /**
     * @param array<string, int> $ratings
     */
    public function __construct(
        public array $ratings
    ) {}
}
