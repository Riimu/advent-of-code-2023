<?php

declare(strict_types=1);

namespace Riimu\AdventOfCode2023\Task\Day4;

use Riimu\AdventOfCode2023\TaskInputInterface;

/**
 * @author Riikka Kalliomäki <riikka.kalliomaki@gmail.com>
 * @copyright Copyright (c) 2023 Riikka Kalliomäki
 * @license http://opensource.org/licenses/mit-license.php MIT License
 */
readonly class Day4Input implements TaskInputInterface
{
    /**
     * @param array<int, ScratchCard> $scratchCards
     */
    public function __construct(
        public array $scratchCards
    ) {}
}
