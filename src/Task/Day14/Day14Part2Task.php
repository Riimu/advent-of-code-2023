<?php

declare(strict_types=1);

namespace Riimu\AdventOfCode2023\Task\Day14;

use Riimu\AdventOfCode2023\Utility\Parse;

/**
 * @author Riikka Kalliomäki <riikka.kalliomaki@gmail.com>
 * @copyright Copyright (c) 2023 Riikka Kalliomäki
 * @license http://opensource.org/licenses/mit-license.php MIT License
 */
class Day14Part2Task extends AbstractDay14Task
{
    private const TYPE_ROCK = 'O';
    private const TYPE_EMPTY = '.';

    protected function solve(Day14Input $input): int
    {
        $height = \count($input->map);
        $width = \count($input->map[0]);
        $emptyHeight = array_fill(0, $height, []);
        $emptyReverserHeight = array_reverse($emptyHeight, true);
        $emptyWidth = array_fill(0, $width, []);
        $emptyReverseWidth = array_reverse($emptyWidth, true);
        $rocks = $emptyHeight;

        foreach ($input->map as $y => $row) {
            foreach ($row as $x => $node) {
                if ($node === self::TYPE_ROCK) {
                    $rocks[$y][$x] = true;
                }
            }
        }

        $tilted = $input->map;
        $previousPositions = [];
        $lastIteration = 0;
        $foundPosition = 0;
        $totalIterations = 1_000_000_000;

        for ($i = 0; $i < $totalIterations; $i++) {
            $nextRocks = $emptyWidth;

            foreach ($rocks[0] as $x => $_) {
                $nextRocks[$x][0] = true;
            }

            unset($rocks[0]);

            foreach ($rocks as $y => $row) {
                foreach ($row as $x => $_) {
                    $next = $y;

                    while ($next > 0 && $tilted[$next - 1][$x] === self::TYPE_EMPTY) {
                        $next--;
                    }

                    if ($next !== $y) {
                        $tilted[$y][$x] = self::TYPE_EMPTY;
                        $tilted[$next][$x] = self::TYPE_ROCK;
                    }

                    $nextRocks[$x][$next] = true;
                }
            }

            $rocks = $nextRocks;
            $nextRocks = $emptyReverserHeight;

            foreach ($rocks[0] as $y => $_) {
                $nextRocks[$y][0] = true;
            }

            unset($rocks[0]);

            foreach ($rocks as $x => $column) {
                foreach ($column as $y => $_) {
                    $next = $x;

                    while ($next > 0 && $tilted[$y][$next - 1] === self::TYPE_EMPTY) {
                        $next--;
                    }

                    if ($next !== $x) {
                        $tilted[$y][$x] = self::TYPE_EMPTY;
                        $tilted[$y][$next] = self::TYPE_ROCK;
                    }

                    $nextRocks[$y][$next] = true;
                }
            }

            $rocks = $nextRocks;
            $nextRocks = $emptyReverseWidth;

            foreach ($rocks[$height - 1] as $x => $_) {
                $nextRocks[$x][$height - 1] = true;
            }

            unset($rocks[$height - 1]);

            foreach ($rocks as $y => $row) {
                foreach ($row as $x => $_) {
                    $next = $y;

                    while ($next < $height - 1 && $tilted[$next + 1][$x] === self::TYPE_EMPTY) {
                        $next++;
                    }

                    if ($next !== $y) {
                        $tilted[$y][$x] = self::TYPE_EMPTY;
                        $tilted[$next][$x] = self::TYPE_ROCK;
                    }

                    $nextRocks[$x][$next] = true;
                }
            }

            $rocks = $nextRocks;
            $nextRocks = $emptyHeight;

            foreach ($rocks[$width - 1] as $y => $_) {
                $nextRocks[$y][$width - 1] = true;
            }

            unset($rocks[$width - 1]);

            foreach ($rocks as $x => $column) {
                foreach ($column as $y => $_) {
                    $next = $x;

                    while ($next < $width - 1 && $tilted[$y][$next + 1] === self::TYPE_EMPTY) {
                        $next++;
                    }

                    if ($next !== $x) {
                        $tilted[$y][$x] = self::TYPE_EMPTY;
                        $tilted[$y][$next] = self::TYPE_ROCK;
                    }

                    $nextRocks[$y][$next] = true;
                }
            }

            $rocks = $nextRocks;
            $positions = [];

            for ($y = 0; $y < $height; $y++) {
                for ($x = 0; $x < $width; $x++) {
                    if (\array_key_exists($x, $nextRocks[$y])) {
                        $positions[] = sprintf('%d,%d', $x, $y);
                    }
                }
            }

            $positionKey = implode(' ', $positions);

            if (\array_key_exists($positionKey, $previousPositions)) {
                $lastIteration = $i;
                $foundPosition = array_search($positionKey, array_keys($previousPositions), true);
                break;
            }

            $previousPositions[$positionKey] = true;
        }

        $remainingIterations = $totalIterations - $lastIteration - 1;
        $loopedIterations = \count($previousPositions) - $foundPosition;
        $finalIteration = $remainingIterations % $loopedIterations;

        $key = array_keys($previousPositions)[$finalIteration + $foundPosition];
        $weights = [];

        foreach (explode(' ', $key) as $rock) {
            $weights[] = $height - Parse::int(explode(',', $rock)[1]);
        }

        return array_sum($weights);
    }
}
