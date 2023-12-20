<?php

declare(strict_types=1);

namespace Riimu\AdventOfCode2023\Task\Day20;

readonly class Pulse
{
    public function __construct(
        public string $source,
        public string $target,
        public bool $highPulse,
    ) {}
}
