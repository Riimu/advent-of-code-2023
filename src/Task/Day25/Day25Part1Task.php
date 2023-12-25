<?php

declare(strict_types=1);

namespace Riimu\AdventOfCode2023\Task\Day25;

/**
 * @author Riikka Kalliomäki <riikka.kalliomaki@gmail.com>
 * @copyright Copyright (c) 2023 Riikka Kalliomäki
 * @license http://opensource.org/licenses/mit-license.php MIT License
 */
class Day25Part1Task extends AbstractDay25Task
{
    protected function solve(Day25Input $input): int
    {
        $wires = [];
        $wireMap = array_fill(0, \count($input->components), []);
        $wireIds = [];

        foreach ($input->components as $component => $connections) {
            $wireIds[$component] ??= \count($wireIds);

            foreach ($connections as $connection) {
                $wireIds[$connection] ??= \count($wireIds);
            }
        }

        foreach ($input->components as $component => $connections) {
            foreach ($connections as $connection) {
                $wires[] = [$wireIds[$component], $wireIds[$connection]];
                $wireMap[$wireIds[$component]][] = $wireIds[$connection];
                $wireMap[$wireIds[$connection]][] = $wireIds[$component];
            }
        }

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
                    'Tested: %s, Speed: %s / sec' . PHP_EOL,
                    number_format($tested),
                    number_format(round(10000 / $seconds))
                );
                $timer = hrtime(true);
            }
        }

        return ($groups[0] ?? 0) * ($groups[1] ?? 0);
    }

    private function getWireCombinations(array $wires): iterable
    {
        shuffle($wires);
        $count = \count($wires);

        for ($i = 0; $i < $count; $i++) {
            for ($j = $i + 1; $j < $count; $j++) {
                for ($k = $j + 1; $k < $count; $k++) {
                    yield [$wires[$i], $wires[$j], $wires[$k]];
                }
            }
        }
    }

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
