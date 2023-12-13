<?php

declare(strict_types=1);

namespace Riimu\AdventOfCode2023\Task\Day13;

use Riimu\AdventOfCode2023\TaskInputInterface;
use Riimu\AdventOfCode2023\TaskInterface;
use Riimu\AdventOfCode2023\Utility\Parse;

/**
 * @author Riikka Kalliomäki <riikka.kalliomaki@gmail.com>
 * @copyright Copyright (c) 2023 Riikka Kalliomäki
 * @license http://opensource.org/licenses/mit-license.php MIT License
 */
abstract class AbstractDay13Task implements TaskInterface
{
    final public function __construct() {}

    public static function createTask(): static
    {
        return new static();
    }

    public function parseInput(string $input): Day13Input
    {
        $maps = [];

        foreach (Parse::sections($input) as $section) {
            $maps[] = new Map(array_map(str_split(...), Parse::lines($section)));
        }

        return new Day13Input($maps);
    }

    public function solveTask(TaskInputInterface $input): string
    {
        if (!$input instanceof Day13Input) {
            throw new \InvalidArgumentException(sprintf("Unexpected input type '%s'", get_debug_type($input)));
        }

        return (string) $this->solve($input);
    }

    abstract protected function solve(Day13Input $input): int;
}
