<?php

declare(strict_types=1);

namespace Riimu\AdventOfCode2023\Task\Day16;

use Riimu\AdventOfCode2023\TaskInputInterface;

/**
 * @author Riikka Kalliomäki <riikka.kalliomaki@gmail.com>
 * @copyright Copyright (c) 2023 Riikka Kalliomäki
 * @license http://opensource.org/licenses/mit-license.php MIT License
 */
readonly class Day16Input implements TaskInputInterface
{
    public const NODE_EMPTY = '.';
    public const NODE_FORWARD_MIRROR = '/';
    public const NODE_BACKWARD_MIRROR = '\\';
    public const NODE_VERTICAL_SPLITTER = '|';
    public const NODE_HORIZONTAL_SPLITTER = '-';

    /**
     * @param array<int, array<int, string>> $map
     */
    public function __construct(
        public array $map
    ) {}
}
