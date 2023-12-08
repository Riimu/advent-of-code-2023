<?php

declare(strict_types=1);

namespace Riimu\AdventOfCode2023\Task\Day8;

/**
 * @author Riikka Kalliomäki <riikka.kalliomaki@gmail.com>
 * @copyright Copyright (c) 2023 Riikka Kalliomäki
 * @license http://opensource.org/licenses/mit-license.php MIT License
 */
readonly class Node
{
    public function __construct(
        public string $left,
        public string $right,
    )
    {
    }
}
