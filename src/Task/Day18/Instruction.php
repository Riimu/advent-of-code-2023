<?php

declare(strict_types=1);

namespace Riimu\AdventOfCode2023\Task\Day18;

use Riimu\AdventOfCode2023\Utility\Direction;

/**
 * @author Riikka Kalliomäki <riikka.kalliomaki@gmail.com>
 * @copyright Copyright (c) 2023 Riikka Kalliomäki
 * @license http://opensource.org/licenses/mit-license.php MIT License
 */
readonly class Instruction
{
    public function __construct(
        public Direction $direction,
        public int $distance,
        public int $color,
    ) {}
}
