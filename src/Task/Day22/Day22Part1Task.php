<?php

declare(strict_types=1);

namespace Riimu\AdventOfCode2023\Task\Day22;

/**
 * @author Riikka Kalliomäki <riikka.kalliomaki@gmail.com>
 * @copyright Copyright (c) 2023 Riikka Kalliomäki
 * @license http://opensource.org/licenses/mit-license.php MIT License
 */
class Day22Part1Task extends AbstractDay22Task
{
    protected function solve(Day22Input $input): int
    {
        $brickState = $this->simulateState($input->bricks);

        $canDisintegrate = 0;

        foreach ($brickState->brickList as $bricks) {
            foreach ($bricks as $brick) {
                if ($this->getSupportedBricks($brick, $brickState) === []) {
                    $canDisintegrate++;
                }
            }
        }

        return $canDisintegrate;
    }
}
