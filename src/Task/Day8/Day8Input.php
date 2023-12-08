<?php

declare(strict_types=1);

namespace Riimu\AdventOfCode2023\Task\Day8;

use Riimu\AdventOfCode2023\TaskInputInterface;

/**
 * @author Riikka Kalliomäki <riikka.kalliomaki@gmail.com>
 * @copyright Copyright (c) 2023 Riikka Kalliomäki
 * @license http://opensource.org/licenses/mit-license.php MIT License
 */
readonly class Day8Input implements TaskInputInterface
{

    /**
     * @param string $instructions
     * @param array<string, Node> $nodes
     */
    public function __construct(
        public string $instructions,
        public array $nodes
    ) {

    }
}
