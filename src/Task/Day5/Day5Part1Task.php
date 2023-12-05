<?php

declare(strict_types=1);

namespace Riimu\AdventOfCode2023\Task\Day5;

use Riimu\AdventOfCode2023\TaskInputInterface;
use Riimu\AdventOfCode2023\TaskInterface;

/**
 * @author Riikka Kalliomäki <riikka.kalliomaki@gmail.com>
 * @copyright Copyright (c) 2023 Riikka Kalliomäki
 * @license http://opensource.org/licenses/mit-license.php MIT License
 * @implements TaskInterface<Day5Input>
 */
class Day5Part1Task implements TaskInterface
{
    public static function createTask(): static
    {
        return new self();
    }

    public function parseInput(string $input): Day5Input
    {
        $sections = preg_split('/(\r\n|\r|\n){2,}/', trim($input));

        $seeds = [];
        $maps = [];

        foreach ($sections as $section) {
            [$name, $data] = explode(':', $section, 2);

            if ($name === 'seeds') {
                $seeds = array_map(
                    static fn(string $x): int => (int) $x,
                    preg_split('/\s+/', $data, 0, PREG_SPLIT_NO_EMPTY),
                );

                continue;
            }

            $rows = preg_split('/[\r\n]+/', trim($data));
            $mappings = [];

            foreach ($rows as $row) {
                $numbers = array_map(
                    static fn(string $x): int => (int) $x,
                    preg_split('/\s+/', trim($row), 0, PREG_SPLIT_NO_EMPTY)
                );

                $mappings[] = new Mapping(...$numbers);
            }

            $maps[substr($name, 0, -4)] = $mappings;
        }

        return new Day5Input($seeds, $maps);
    }

    public function solveTask(TaskInputInterface $input): string
    {
        $maps = [
            'seed-to-soil',
            'soil-to-fertilizer',
            'fertilizer-to-water',
            'water-to-light',
            'light-to-temperature',
            'temperature-to-humidity',
            'humidity-to-location',
        ];

        $locations = [];

        foreach ($input->seeds as $number) {
            foreach ($maps as $name) {
                foreach ($input->maps[$name] as $mapping) {
                    if ($number >= $mapping->sourceStart && $number < $mapping->sourceStart + $mapping->length) {
                        $number = $mapping->destinationStart + ($number - $mapping->sourceStart);
                        continue 2;
                    }
                }
            }

            $locations[] = $number;
        }

        return (string) min($locations);
    }

}
