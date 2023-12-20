<?php

declare(strict_types=1);

namespace Riimu\AdventOfCode2023\Task\Day20;

use Riimu\AdventOfCode2023\TaskInputInterface;

/**
 * @author Riikka Kalliomäki <riikka.kalliomaki@gmail.com>
 * @copyright Copyright (c) 2023 Riikka Kalliomäki
 * @license http://opensource.org/licenses/mit-license.php MIT License
 */
readonly class Day20Input implements TaskInputInterface
{
    /**
     * @param array<string, CommunicationModule> $modules
     */
    public function __construct(
        public array $modules
    ) {}
}
