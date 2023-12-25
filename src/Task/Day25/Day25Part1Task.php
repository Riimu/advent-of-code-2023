<?php

declare(strict_types=1);

namespace Riimu\AdventOfCode2023\Task\Day25;

use Riimu\AdventOfCode2023\Utility\Parse;

/**
 * @author Riikka Kalliomäki <riikka.kalliomaki@gmail.com>
 * @copyright Copyright (c) 2023 Riikka Kalliomäki
 * @license http://opensource.org/licenses/mit-license.php MIT License
 */
class Day25Part1Task extends AbstractDay25Task
{
    protected function solve(Day25Input $input): int
    {
        $wireMap = array_fill(0, \count($input->components), []);
        $componentIds = [];

        foreach ($input->components as $component => $connections) {
            $componentIds[$component] ??= \count($componentIds);

            foreach ($connections as $connection) {
                $componentIds[$connection] ??= \count($componentIds);
            }
        }

        foreach ($input->components as $component => $connections) {
            foreach ($connections as $connection) {
                $wireMap[$componentIds[$component]][] = $componentIds[$connection];
                $wireMap[$componentIds[$connection]][] = $componentIds[$component];
            }
        }

        $wires = $this->getSortedWireList($wireMap);
        $groups = [];
        $tested = 0;
        $timer = hrtime(true);

        foreach ($this->getWireCombinations($wires) as $exclusions) {
            $groups = $this->countGroups($wireMap, $exclusions);

            if (\count($groups) === 2) {
                break;
            }

            $tested++;

            if ($tested % 10000 === 0) {
                $seconds = (hrtime(true) - $timer) / 10 ** 9;
                printf(
                    'Tested: %s, Speed: %s / sec' . \PHP_EOL,
                    number_format($tested),
                    number_format(round(10000 / $seconds))
                );
                $timer = hrtime(true);
            }
        }

        return ($groups[0] ?? 0) * ($groups[1] ?? 0);
    }

    /**
     * @param array<int, array<int, int>> $map
     * @return array<int, array{0: int, 1: int}>
     */
    private function getSortedWireList(array $map): array
    {
        foreach ($map as $key => $nodes) {
            sort($nodes);
            $map[$key] = $nodes;
        }

        $counts = [];
        $start = array_key_first($map) ?? 0;
        $furthest[] = [];

        do {
            $furthest[$start] = true;
            $start = $this->findFurthestNode($map, $start);
        } while (!isset($furthest[$start]));

        $testNodes = \array_slice(array_keys($furthest), -2);

        foreach ($testNodes as $start) {
            foreach (array_keys($map) as $goal) {
                $path = $this->findShortestPath($map, $start, $goal);

                if ($path === null) {
                    throw new \UnexpectedValueException('Unexpected path');
                }

                $pathLength = \count($path);

                for ($i = 1; $i < $pathLength; $i++) {
                    $key = $path[$i] < $path[$i - 1]
                        ? sprintf('%d-%d', $path[$i], $path[$i - 1])
                        : sprintf('%d-%d', $path[$i - 1], $path[$i]);

                    $counts[$key] ??= 0;
                    $counts[$key]++;
                }
            }
        }

        arsort($counts);
        $wires = [];

        foreach (array_keys($counts) as $key) {
            $parts = explode('-', $key);
            $wires[] = [Parse::int($parts[0]), Parse::int($parts[1])];
        }

        foreach ($map as $a => $nodes) {
            foreach ($nodes as $b) {
                $wire = [min($a, $b), max($a, $b)];

                if (!\in_array($wire, $wires, true)) {
                    $wires[] = $wire;
                }
            }
        }

        return \array_slice($wires, 0, 100);
    }

    /**
     * @param array<int, array<int, int>> $map
     * @param int $start
     * @return int
     */
    private function findFurthestNode(array $map, int $start): int
    {
        $queue = [$start];
        $visited = array_fill(0, \count($map), false);
        $lastNode = $start;

        do {
            $nextQueue = [];

            foreach ($queue as $node) {
                foreach ($map[$node] as $next) {
                    if ($visited[$next]) {
                        continue;
                    }

                    $nextQueue[] = $next;
                    $visited[$next] = true;
                    $lastNode = $next;
                }
            }

            $queue = $nextQueue;
        } while ($queue !== []);

        return $lastNode;
    }

    /**
     * @param array<int, array<int, int>> $map
     * @param int $start
     * @param int $goal
     * @return array<int, int>|null
     */
    private function findShortestPath(array $map, int $start, int $goal): ?array
    {
        if ($goal === $start) {
            return [];
        }

        $queue = [[$start, 0, []]];
        $visited = array_fill(0, \count($map), false);

        do {
            $nextQueue = [];

            foreach ($queue as [$node, $steps, $path]) {
                $path[] = $node;
                $steps++;

                foreach ($map[$node] as $next) {
                    if ($visited[$next]) {
                        continue;
                    }

                    if ($next === $goal) {
                        return [...$path, $next];
                    }

                    $nextQueue[] = [$next, $steps, $path];
                    $visited[$next] = true;
                }
            }

            $queue = $nextQueue;
        } while ($queue !== []);

        return null;
    }

    /**
     * @param array<int, array{0: int, 1: int}> $wires
     * @return iterable<int, array<int, array{0: int, 1: int}>>
     */
    private function getWireCombinations(array $wires): iterable
    {
        $count = \count($wires);

        for ($i = 0; $i < $count; $i++) {
            for ($j = $i + 1; $j < $count; $j++) {
                for ($k = $j + 1; $k < $count; $k++) {
                    yield [$wires[$i], $wires[$j], $wires[$k]];
                }
            }
        }
    }

    /**
     * @param array<int, array<int, int>> $map
     * @param array<int, array{0: int, 1: int}> $exclusions
     * @return array<int, int>
     */
    private function countGroups(array $map, array $exclusions): array
    {
        $visited = array_fill(0, \count($map), false);
        $groups = [];

        foreach ($exclusions as [$a, $b]) {
            unset($map[$a][array_search($b, $map[$a], true)]);
            unset($map[$b][array_search($a, $map[$b], true)]);
        }

        do {
            $count = 0;
            $start = array_search(false, $visited, true);
            $exploreQueue = [$start];
            $visited[$start] = true;

            do {
                $nextQueue = [];

                foreach ($exploreQueue as $search) {
                    $count++;

                    foreach ($map[$search] as $node) {
                        if (!$visited[$node]) {
                            $nextQueue[] = $node;
                            $visited[$node] = true;
                        }
                    }
                }

                $exploreQueue = $nextQueue;
            } while ($exploreQueue !== []);

            $groups[] = $count;
        } while (\in_array(false, $visited, true));

        return $groups;
    }
}
