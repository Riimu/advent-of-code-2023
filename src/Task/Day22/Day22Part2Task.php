<?php

declare(strict_types=1);

namespace Riimu\AdventOfCode2023\Task\Day22;

/**
 * @author Riikka Kalliomäki <riikka.kalliomaki@gmail.com>
 * @copyright Copyright (c) 2023 Riikka Kalliomäki
 * @license http://opensource.org/licenses/mit-license.php MIT License
 */
class Day22Part2Task extends AbstractDay22Task
{
    protected function solve(Day22Input $input): int
    {
        $brickState = $this->simulateState(BrickState::createFromInput($input));
        $totalFallenBricks = 0;

        foreach ($brickState->brickList as $bricks) {
            foreach ($bricks as $brick) {
                if ($this->getSupportedBricks($brick, $brickState) !== []) {
                    $totalFallenBricks += $this->simulateState($brickState->removeBrick($brick), $brick->getTop() + 1)->changes;
                }
            }
        }

        return $totalFallenBricks;
    }
}
