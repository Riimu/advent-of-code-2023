<?php

declare(strict_types=1);

namespace Riimu\AdventOfCode2023\Task\Day21;

use Riimu\AdventOfCode2023\TaskInputInterface;

/**
 * @author Riikka Kalliomäki <riikka.kalliomaki@gmail.com>
 * @copyright Copyright (c) 2023 Riikka Kalliomäki
 * @license http://opensource.org/licenses/mit-license.php MIT License
 */
readonly class Day21Input implements TaskInputInterface
{
    public const NODE_SPACE = '.';
    public const NODE_START = 'S';
    public const NODE_WALL = '#';

    /**
     * @param array<int, array<int, string>> $map
     */
    public function __construct(
        public array $map,
    ) {}
}
