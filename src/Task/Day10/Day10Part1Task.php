<?php

declare(strict_types=1);

namespace Riimu\AdventOfCode2023\Task\Day10;

/**
 * @author Riikka Kalliomäki <riikka.kalliomaki@gmail.com>
 * @copyright Copyright (c) 2023 Riikka Kalliomäki
 * @license http://opensource.org/licenses/mit-license.php MIT License
 */
class Day10Part1Task extends AbstractDay10Task
{
    protected function solve(Day10Input $input): int
    {
        $pipes = $this->findValidPipes($input->map);
        $distances = [];

        foreach ($pipes as $route) {
            foreach ($route as $distance => [$x, $y]) {
                $key = sprintf('%d-%d', $x, $y);

                $distances[$key] = isset($distances[$key])
                    ? min($distances[$key], $distance)
                    : $distance;
            }
        }

        return max($distances);
    }
}
