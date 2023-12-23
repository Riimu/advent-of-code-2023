<?php

declare(strict_types=1);

namespace Riimu\AdventOfCode2023\Task\Day23;

use Riimu\AdventOfCode2023\TaskInputInterface;

/**
 * @author Riikka Kalliomäki <riikka.kalliomaki@gmail.com>
 * @copyright Copyright (c) 2023 Riikka Kalliomäki
 * @license http://opensource.org/licenses/mit-license.php MIT License
 */
readonly class Day23Input implements TaskInputInterface
{
    public const NODE_SPACE = '.';
    public const NODE_WALL = '#';
    public const NODE_SLOPE_LEFT = '<';
    public const NODE_SLOPE_RIGHT = '>';
    public const NODE_SLOPE_UP = '^';
    public const NODE_SLOPE_DOWN = 'v';

    /**
     * @param array<int, array<int, string>> $map
     */
    public function __construct(
        public array $map
    ) {}
}
