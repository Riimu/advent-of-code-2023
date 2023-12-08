<?php

declare(strict_types=1);

namespace Riimu\AdventOfCode2023\Task\Day8;

use Riimu\AdventOfCode2023\Utility\Math;

/**
 * @author Riikka Kalliomäki <riikka.kalliomaki@gmail.com>
 * @copyright Copyright (c) 2023 Riikka Kalliomäki
 * @license http://opensource.org/licenses/mit-license.php MIT License
 */
class Day8Part2Task extends AbstractDay8Task
{
    protected function solve(Day8Input $input): int
    {
        $stepsToExit = [];

        foreach (array_keys($input->nodes) as $node) {
            if ($node[2] === 'A') {
                $stepsToExit[] = $this->countStepsToExit($node, $input->instructions, $input->nodes);
            }
        }

        return Math::getLeastCommonMultiple($stepsToExit);
    }
}
