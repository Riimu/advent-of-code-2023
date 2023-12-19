<?php

declare(strict_types=1);

namespace Riimu\AdventOfCode2023\Task\Day19;

use Riimu\AdventOfCode2023\TaskInputInterface;

/**
 * @author Riikka Kalliomäki <riikka.kalliomaki@gmail.com>
 * @copyright Copyright (c) 2023 Riikka Kalliomäki
 * @license http://opensource.org/licenses/mit-license.php MIT License
 */
readonly class Day19Input implements TaskInputInterface
{
    /**
     * @param array<string, Workflow> $workflows
     * @param array<int, MachinePart> $parts
     */
    public function __construct(
        public array $workflows,
        public array $parts
    ) {}
}
