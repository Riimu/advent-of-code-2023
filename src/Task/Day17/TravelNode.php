<?php

declare(strict_types=1);

namespace Riimu\AdventOfCode2023\Task\Day17;

use Riimu\AdventOfCode2023\Utility\Direction;

/**
 * @author Riikka Kalliomäki <riikka.kalliomaki@gmail.com>
 * @copyright Copyright (c) 2023 Riikka Kalliomäki
 * @license http://opensource.org/licenses/mit-license.php MIT License
 */
readonly class TravelNode
{
    public function __construct(
        public int $x,
        public int $y,
        public int $heatLoss,
        public Direction $direction,
        public int $steps,
    ) {}
}
