<?php

declare(strict_types=1);

namespace Riimu\AdventOfCode2023\Task\Day6;

use Riimu\AdventOfCode2023\TaskInputInterface;

/**
 * @author Riikka Kalliomäki <riikka.kalliomaki@gmail.com>
 * @copyright Copyright (c) 2023 Riikka Kalliomäki
 * @license http://opensource.org/licenses/mit-license.php MIT License
 */
class Day6Input implements TaskInputInterface
{
    /**
     * @param array<int, int> $times
     * @param array<int, int> $distances
     */
    public function __construct(
        public readonly array $times,
        public readonly array $distances,
    )
    {
    }
}
