<?php

declare(strict_types=1);

namespace Riimu\AdventOfCode2023\Task\Day20;

/**
 * @author Riikka Kalliomäki <riikka.kalliomaki@gmail.com>
 * @copyright Copyright (c) 2023 Riikka Kalliomäki
 * @license http://opensource.org/licenses/mit-license.php MIT License
 */
readonly class Pulse
{
    public function __construct(
        public string $source,
        public string $target,
        public bool $highPulse,
    ) {}
}
