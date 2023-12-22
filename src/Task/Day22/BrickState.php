<?php

declare(strict_types=1);

namespace Riimu\AdventOfCode2023\Task\Day22;

/**
 * @author Riikka Kalliomäki <riikka.kalliomaki@gmail.com>
 * @copyright Copyright (c) 2023 Riikka Kalliomäki
 * @license http://opensource.org/licenses/mit-license.php MIT License
 */
class BrickState
{
    /**
     * @param array<int, array<int, array<int, Brick>>> $brickTops
     * @param array<int, array<int, Brick>> $brickList
     */
    public function __construct(
        public array $brickTops,
        public array $brickList
    ) {}
}
