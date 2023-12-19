<?php

declare(strict_types=1);

namespace Riimu\AdventOfCode2023\Task\Day19;

use Riimu\AdventOfCode2023\TaskInputInterface;
use Riimu\AdventOfCode2023\TaskInterface;
use Riimu\AdventOfCode2023\Utility\Parse;

/**
 * @author Riikka Kalliomäki <riikka.kalliomaki@gmail.com>
 * @copyright Copyright (c) 2023 Riikka Kalliomäki
 * @license http://opensource.org/licenses/mit-license.php MIT License
 */
abstract class AbstractDay19Task implements TaskInterface
{
    final public function __construct() {}

    public static function createTask(): static
    {
        return new static();
    }

    public function parseInput(string $input): Day19Input
    {
        [$ruleSection, $partSection] = Parse::sections($input);

        $workflows = [];
        $parts = [];

        foreach (Parse::lines($ruleSection) as $line) {
            if (!preg_match('/^([a-z]+)\{([^}]+)}$/', $line, $match)) {
                throw new \RuntimeException("Unexpected rule line '$line'");
            }

            $name = $match[1];
            $rules = [];

            foreach (explode(',', $match[2]) as $rule) {
                if (preg_match('/^([a-z]+|[AR])$/', $rule)) {
                    $rules[] = new DefaultWorkflowRule($rule);
                    continue;
                }

                if (!preg_match('/^([a-z]+)([<>])(\d+):([a-z]+|[AR])$/', $rule, $ruleMatch)) {
                    throw new \RuntimeException("Unexpected rule definition '$rule'");
                }

                $rules[] = new WorkflowRule(
                    $ruleMatch[1],
                    Operator::from($ruleMatch[2]),
                    Parse::int($ruleMatch[3]),
                    $ruleMatch[4]
                );
            }

            $workflows[$name] = new Workflow($rules);
        }

        foreach (Parse::lines($partSection) as $line) {
            preg_match_all('/(?<=[{,])([xmas])=(\d+)(?=[,}])/', $line, $matches);

            if (!isset($matches[1]) || array_diff(['x', 'm', 'a', 's'], $matches[1]) !== []) {
                throw new \RuntimeException("Unexpected part line '$line'");
            }

            $parts[] = new MachinePart(array_combine($matches[1], array_map(Parse::int(...), $matches[2])));
        }

        return new Day19Input($workflows, $parts);
    }

    public function solveTask(TaskInputInterface $input): string
    {
        if (!$input instanceof Day19Input) {
            throw new \InvalidArgumentException(sprintf("Unexpected input type '%s'", get_debug_type($input)));
        }

        return (string) $this->solve($input);
    }

    abstract protected function solve(Day19Input $input): int;
}
