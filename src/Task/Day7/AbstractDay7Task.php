<?php

declare(strict_types=1);

namespace Riimu\AdventOfCode2023\Task\Day7;

use Riimu\AdventOfCode2023\Parse;
use Riimu\AdventOfCode2023\TaskInputInterface;
use Riimu\AdventOfCode2023\TaskInterface;

/**
 * @author Riikka Kalliomäki <riikka.kalliomaki@gmail.com>
 * @copyright Copyright (c) 2023 Riikka Kalliomäki
 * @license http://opensource.org/licenses/mit-license.php MIT License
 */
abstract class AbstractDay7Task implements TaskInterface
{
    final public function __construct() {}

    public static function createTask(): static
    {
        return new static();
    }

    public function parseInput(string $input): Day7Input
    {
        $lines = Parse::lines($input);
        $hands = [];

        foreach ($lines as $line) {
            $data = explode(' ', $line);
            $hands[] = new Hand($data[0], Parse::int($data[1]));
        }

        return new Day7Input($hands);
    }

    public function solveTask(TaskInputInterface $input): string
    {
        if (!$input instanceof Day7Input) {
            throw new \InvalidArgumentException(sprintf("Unexpected input type '%s'", get_debug_type($input)));
        }

        return (string) $this->solve($input);
    }

    abstract protected function solve(Day7Input $input): int;
}
