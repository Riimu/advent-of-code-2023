<?php

declare(strict_types=1);

namespace Riimu\AdventOfCode2023\Task\Day24;

use Riimu\AdventOfCode2023\TaskInputInterface;

/**
 * @author Riikka Kalliomäki <riikka.kalliomaki@gmail.com>
 * @copyright Copyright (c) 2023 Riikka Kalliomäki
 * @license http://opensource.org/licenses/mit-license.php MIT License
 */
readonly class Day24Input implements TaskInputInterface
{
    /**
     * @param array<int, array{0: int, 1: int, 2:int}> $hailstones
     * @param array<int, array{0: int, 1: int, 2:int}> $velocities
     */
    public function __construct(
        public array $hailstones,
        public array $velocities,
    ) {}
}
