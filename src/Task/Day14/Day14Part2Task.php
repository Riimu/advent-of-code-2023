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
        $nextRocks = $emptyHeight;

        foreach ($input->map as $y => $row) {
            foreach ($row as $x => $node) {
                if ($node === self::TYPE_ROCK) {
                    $nextRocks[$y][] = $x;
                }
            }
        }

        $tilted = $input->map;
        $previousPositions = [];
        $lastIteration = 0;
        $foundPosition = 0;
        $totalIterations = 1_000_000_000;

        for ($i = 0; $i < $totalIterations; $i++) {
            $rocks = $nextRocks;
            $nextRocks = $emptyWidth;

            foreach ($rocks as $y => $row) {
                foreach ($row as $x) {
                    $next = $y;

                    while ($next > 0 && $tilted[$next - 1][$x] === self::TYPE_EMPTY) {
                        $next--;
                    }

                    if ($next !== $y) {
                        $tilted[$y][$x] = self::TYPE_EMPTY;
                        $tilted[$next][$x] = self::TYPE_ROCK;
                    }

                    $nextRocks[$x][] = $next;
                }
            }

            $rocks = $nextRocks;
            $nextRocks = $emptyReverserHeight;

            foreach ($rocks as $x => $column) {
                foreach ($column as $y) {
                    $next = $x;

                    while ($next > 0 && $tilted[$y][$next - 1] === self::TYPE_EMPTY) {
                        $next--;
                    }

                    if ($next !== $x) {
                        $tilted[$y][$x] = self::TYPE_EMPTY;
                        $tilted[$y][$next] = self::TYPE_ROCK;
                    }

                    $nextRocks[$y][] = $next;
                }
            }

            $rocks = $nextRocks;
            $nextRocks = $emptyReverseWidth;

            foreach ($rocks as $y => $row) {
                foreach ($row as $x) {
                    $next = $y;

                    while ($next < $height - 1 && $tilted[$next + 1][$x] === self::TYPE_EMPTY) {
                        $next++;
                    }

                    if ($next !== $y) {
                        $tilted[$y][$x] = self::TYPE_EMPTY;
                        $tilted[$next][$x] = self::TYPE_ROCK;
                    }

                    $nextRocks[$x][] = $next;
                }
            }

            $rocks = $nextRocks;
            $nextRocks = $emptyHeight;

            foreach ($rocks as $x => $column) {
                foreach ($column as $y) {
                    $next = $x;

                    while ($next < $width - 1 && $tilted[$y][$next + 1] === self::TYPE_EMPTY) {
                        $next++;
                    }

                    if ($next !== $x) {
                        $tilted[$y][$x] = self::TYPE_EMPTY;
                        $tilted[$y][$next] = self::TYPE_ROCK;
                    }

                    $nextRocks[$y][] = $next;
                }
            }

            $positions = [];

            for ($y = 0; $y < $height; $y++) {
                for ($x = 0; $x < $width; $x++) {
                    if ($tilted[$y][$x] === self::TYPE_ROCK) {
                        $positions[] = sprintf('%d,%d', $x, $y);
                    }
                }
            }

            $positionKey = implode(' ', $positions);

            if (\array_key_exists($positionKey, $previousPositions)) {
                $lastIteration = $i;
                $foundPosition = $previousPositions[$positionKey];
                break;
            }

            $previousPositions[$positionKey] = \count($previousPositions);
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
