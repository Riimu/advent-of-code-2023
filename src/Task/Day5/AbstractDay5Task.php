<?php

declare(strict_types=1);

namespace Riimu\AdventOfCode2023\Task\Day5;

use Riimu\AdventOfCode2023\TaskInputInterface;
use Riimu\AdventOfCode2023\TaskInterface;
use Riimu\AdventOfCode2023\Utility\Parse;

/**
 * @author Riikka Kalliomäki <riikka.kalliomaki@gmail.com>
 * @copyright Copyright (c) 2023 Riikka Kalliomäki
 * @license http://opensource.org/licenses/mit-license.php MIT License
 */
abstract class AbstractDay5Task implements TaskInterface
{
    protected const INPUT_MAPS = [
        'seed-to-soil',
        'soil-to-fertilizer',
        'fertilizer-to-water',
        'water-to-light',
        'light-to-temperature',
        'temperature-to-humidity',
        'humidity-to-location',
    ];

    final public function __construct() {}

    public static function createTask(): static
    {
        return new static();
    }

    public function parseInput(string $input): Day5Input
    {
        $sections = Parse::namedSections($input);

        $seeds = Parse::ints($sections['seeds']);
        $maps = [];
        unset($sections['seeds']);

        foreach ($sections as $name => $data) {
            $rows = Parse::lines($data);
            $mappings = [];

            foreach ($rows as $row) {
                $mappings[] = new Mapping(...Parse::ints($row));
            }

            $maps[substr($name, 0, -4)] = $mappings;
        }

        return new Day5Input($seeds, $maps);
    }

    public function solveTask(TaskInputInterface $input): string
    {
        if (!$input instanceof Day5Input) {
            throw new \InvalidArgumentException(sprintf("Unexpected input type '%s'", get_debug_type($input)));
        }

        return (string) $this->solve($input);
    }

    abstract protected function solve(Day5Input $input): int;
}
