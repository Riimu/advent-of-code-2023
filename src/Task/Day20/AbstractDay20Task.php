<?php

declare(strict_types=1);

namespace Riimu\AdventOfCode2023\Task\Day20;

use Riimu\AdventOfCode2023\TaskInputInterface;
use Riimu\AdventOfCode2023\TaskInterface;
use Riimu\AdventOfCode2023\Utility\Parse;

/**
 * @author Riikka Kalliomäki <riikka.kalliomaki@gmail.com>
 * @copyright Copyright (c) 2023 Riikka Kalliomäki
 * @license http://opensource.org/licenses/mit-license.php MIT License
 */
abstract class AbstractDay20Task implements TaskInterface
{
    final public function __construct() {}

    public static function createTask(): static
    {
        return new static();
    }

    public function parseInput(string $input): Day20Input
    {
        $modules = [];

        foreach (Parse::lines($input) as $line) {
            $parts = preg_split('/\s*->\s*/', $line);

            if (!isset($parts[0], $parts[1])) {
                throw new \RuntimeException("Unexpected module '$line'");
            }

            [$name, $outputText] = $parts;
            $outputs = preg_split('/\s*,\s*/', $outputText);

            if (!\is_array($outputs)) {
                throw new \RuntimeException("Unexpected outputs line '$outputs'");
            }

            $module = match ($name[0]) {
                '%' => new CommunicationModule(substr($name, 1), ModuleType::FlipFlop, $outputs),
                '&' => new CommunicationModule(substr($name, 1), ModuleType::Conjuction, $outputs),
                default => new CommunicationModule($name, ModuleType::Broadcaster, $outputs),
            };

            $modules[$module->name] = $module;
        }

        return new Day20Input($modules);
    }

    public function solveTask(TaskInputInterface $input): string
    {
        if (!$input instanceof Day20Input) {
            throw new \InvalidArgumentException(sprintf("Unexpected input type '%s'", get_debug_type($input)));
        }

        return (string) $this->solve($input);
    }

    abstract protected function solve(Day20Input $input): int;

    protected function processPulse(CommunicationModule$module, Pulse $pulse, ModuleState $state, PulseQueue $queue): void
    {
        if ($module->type === ModuleType::FlipFlop) {
            if ($pulse->highPulse) {
                return;
            }

            $state->flipFlops[$module->name] = !$state->flipFlops[$module->name];
            $queue->enqueueOutput($module, $state->flipFlops[$module->name]);
        } elseif ($module->type === ModuleType::Conjuction) {
            $state->conjunctions[$module->name][$pulse->source] = $pulse->highPulse;
            $outputHighPulse = false;

            foreach ($state->conjunctions[$module->name] as $memory) {
                if (!$memory) {
                    $outputHighPulse = true;
                    break;
                }
            }

            $queue->enqueueOutput($module, $outputHighPulse);
        }
    }
}
