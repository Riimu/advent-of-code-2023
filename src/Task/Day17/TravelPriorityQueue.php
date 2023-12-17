<?php

declare(strict_types=1);

namespace Riimu\AdventOfCode2023\Task\Day17;

/**
 * @author Riikka Kalliomäki <riikka.kalliomaki@gmail.com>
 * @copyright Copyright (c) 2023 Riikka Kalliomäki
 * @license http://opensource.org/licenses/mit-license.php MIT License
 * @extends \SplPriorityQueue<int, TravelNode>
 */
class TravelPriorityQueue extends \SplPriorityQueue
{
    public function compare(mixed $priority1, mixed $priority2): int
    {
        return $priority2 <=> $priority1;
    }
}
