<?php

declare(strict_types=1);

namespace Riimu\AdventOfCode2023\Task\Day22;

/**
 * @author Riikka Kalliomäki <riikka.kalliomaki@gmail.com>
 * @copyright Copyright (c) 2023 Riikka Kalliomäki
 * @license http://opensource.org/licenses/mit-license.php MIT License
 */
readonly class BrickCoordinate
{
    public function __construct(
        public int $x,
        public int $y,
        public int $z,
    ) {}
}
