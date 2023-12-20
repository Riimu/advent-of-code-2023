<?php

declare(strict_types=1);

namespace Riimu\AdventOfCode2023\Task\Day20;

/**
 * @author Riikka Kalliomäki <riikka.kalliomaki@gmail.com>
 * @copyright Copyright (c) 2023 Riikka Kalliomäki
 * @license http://opensource.org/licenses/mit-license.php MIT License
 */
class Day20Part1Task extends AbstractDay20Task
{
    protected function solve(Day20Input $input): int
    {
        $moduleInputs = [];

        foreach ($input->modules as $module) {
            foreach ($module->outputs as $name) {
                $moduleInputs[$name][] = $module->name;
            }
        }

        $flipFlopState = [];
        $conjunctionState = [];

        foreach ($input->modules as $module) {
            if ($module->type === ModuleType::FlipFlop) {
                $flipFlopState[$module->name] = false;
            } elseif ($module->type === ModuleType::Conjuction) {
                $conjunctionState[$module->name] = array_fill_keys($moduleInputs[$module->name], false);
            }
        }

        $previousStates = [];
        $currentState = $this->getStateKey($flipFlopState, $conjunctionState);

        for ($i = 0; $i < 1000; $i++) {
            /** @var \SplQueue<Pulse> $pulses */
            $pulses = new \SplQueue();
            $this->addPulse($pulses, $input->modules[CommunicationModule::BROADCASTER], false);
            $pulseCount = [1, 0];

            while (!$pulses->isEmpty()) {
                $pulse = $pulses->dequeue();
                $name = $pulse->target;
                $pulseCount[$pulse->highPulse ? 1 : 0]++;

                if (!isset($input->modules[$name])) {
                    continue;
                }

                $module = $input->modules[$name];

                if ($module->type === ModuleType::FlipFlop) {
                    if ($pulse->highPulse) {
                        continue;
                    }

                    $flipFlopState[$name] = !$flipFlopState[$name];
                    $this->addPulse($pulses, $module, $flipFlopState[$name]);
                } elseif ($module->type === ModuleType::Conjuction) {
                    $conjunctionState[$name][$pulse->source] = $pulse->highPulse;
                    $allHigh = \count(array_filter($conjunctionState[$name])) === \count($conjunctionState[$name]);
                    $this->addPulse($pulses, $module, !$allHigh);
                }
            }

            $previousStates[$currentState] = $pulseCount;
            $currentState = $this->getStateKey($flipFlopState, $conjunctionState);

            if (\array_key_exists($currentState, $previousStates)) {
                break;
            }
        }

        if ($i === 1000) {
            return array_sum(array_column($previousStates, 0)) * array_sum(array_column($previousStates, 1));
        }

        $totalLow = 0;
        $totalHigh = 0;
        $removed = 0;

        foreach ($previousStates as $state => $counts) {
            if ($state === $currentState) {
                break;
            }

            $totalLow += $counts[0];
            $totalHigh += $counts[1];
            $removed++;
            unset($previousStates[$state]);
        }

        $loops = intdiv(1000 - $removed, \count($previousStates));
        $totalLow += array_sum(array_column($previousStates, 0)) * $loops;
        $totalHigh += array_sum(array_column($previousStates, 1)) * $loops;
        $remaining = (1000 - $removed) % \count($previousStates);

        for ($i = 0; $i < $remaining; $i++) {
            $counts = array_shift($previousStates) ?? [0, 0];
            $totalLow += $counts[0];
            $totalHigh += $counts[1];
        }

        return $totalLow * $totalHigh;
    }

    /**
     * @param array<string, bool> $flipFlopState
     * @param array<string, array<string, bool>> $conjunctionState
     * @return string
     */
    private function getStateKey(array $flipFlopState, array $conjunctionState): string
    {
        return '0b'
            . implode('', array_map(intval(...), $flipFlopState))
            . implode('', array_map(static fn(array $x): string => implode('', array_map(intval(...), $x)), $conjunctionState));
    }

    /**
     * @param \SplQueue<Pulse> $pulses
     * @param CommunicationModule $module
     * @param bool $high
     * @return void
     */
    private function addPulse(\SplQueue $pulses, CommunicationModule $module, bool $high): void
    {
        foreach ($module->outputs as $output) {
            $pulses->enqueue(new Pulse($module->name, $output, $high));
        }
    }
}
