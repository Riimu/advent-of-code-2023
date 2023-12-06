<?php

declare(strict_types=1);

namespace Riimu\AdventOfCode2023\Task\Day5;

/**
 * @author Riikka Kalliomäki <riikka.kalliomaki@gmail.com>
 * @copyright Copyright (c) 2023 Riikka Kalliomäki
 * @license http://opensource.org/licenses/mit-license.php MIT License
 */
class Mapping
{
    public function __construct(
        public readonly int $destinationStart,
        public readonly int $sourceStart,
        public readonly int $length,
    ) {}
}
