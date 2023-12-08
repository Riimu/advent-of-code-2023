<?php

declare(strict_types=1);

namespace Riimu\AdventOfCode2023\Task\Day8;

use Riimu\AdventOfCode2023\TaskInputInterface;
use Riimu\AdventOfCode2023\TaskInterface;
use Riimu\AdventOfCode2023\Utility\Parse;

/**
 * @author Riikka Kalliomäki <riikka.kalliomaki@gmail.com>
 * @copyright Copyright (c) 2023 Riikka Kalliomäki
 * @license http://opensource.org/licenses/mit-license.php MIT License
 */
abstract class AbstractDay8Task implements TaskInterface
{
    final public function __construct() {}

    public static function createTask(): static
    {
        return new static();
    }

    public function parseInput(string $input): Day8Input
    {
        $lines = Parse::lines($input);
        $instructions = array_shift($lines) ?? '';
        $nodes = [];

        foreach ($lines as $line) {
            if (!preg_match('/(.{3}) = \((.{3}), (.{3})\)/', $line, $match)) {
                continue;
            }

            $nodes[$match[1]] = new Node($match[2], $match[3]);
        }

        return new Day8Input($instructions, $nodes);
    }

    public function solveTask(TaskInputInterface $input): string
    {
        if (!$input instanceof Day8Input) {
            throw new \InvalidArgumentException(sprintf("Unexpected input type '%s'", get_debug_type($input)));
        }

        return (string) $this->solve($input);
    }

    abstract protected function solve(Day8Input $input): int;

    /**
     * @param string $node
     * @param string $instructions
     * @param array<string, Node> $map
     * @return int
     */
    protected function countStepsToExit(string $node, string $instructions, array $map): int
    {
        $steps = 0;
        $length = \strlen($instructions);

        while ($node[2] !== 'Z') {
            $node = $instructions[$steps % $length] === 'L'
                ? $map[$node]->left
                : $map[$node]->right;
            $steps++;
        }

        return $steps;
    }
}
