<?php

declare(strict_types=1);

namespace Riimu\AdventOfCode2023\Task\Day4;

/**
 * @author Riikka Kalliomäki <riikka.kalliomaki@gmail.com>
 * @copyright Copyright (c) 2023 Riikka Kalliomäki
 * @license http://opensource.org/licenses/mit-license.php MIT License
 */
class ScratchCard
{
    /**
     * @param array<int, int> $winningNumbers
     * @param array<int, int> $cardNumbers
     */
    public function __construct(
        public readonly array $winningNumbers,
        public readonly array $cardNumbers,
    )
    {
    }
}
