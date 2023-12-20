<?php

declare(strict_types=1);

namespace Riimu\AdventOfCode2023\Task\Day20;

use Riimu\AdventOfCode2023\Utility\Math;

/**
 * @author Riikka Kalliomäki <riikka.kalliomaki@gmail.com>
 * @copyright Copyright (c) 2023 Riikka Kalliomäki
 * @license http://opensource.org/licenses/mit-license.php MIT License
 */
class Day20Part2Task extends AbstractDay20Task
{
    protected function solve(Day20Input $input): int
    {
        $moduleInputs = [];

        foreach ($input->modules as $module) {
            foreach ($module->outputs as $name) {
                $moduleInputs[$name][] = $module->name;
            }
        }

        $emptyFlipFlopState = [];
        $emptyConjunctionState = [];

        foreach ($input->modules as $module) {
            if ($module->type === ModuleType::FlipFlop) {
                $emptyFlipFlopState[$module->name] = false;
            } elseif ($module->type === ModuleType::Conjuction) {
                $emptyConjunctionState[$module->name] = array_fill_keys($moduleInputs[$module->name], false);
            }
        }

        $counts = [];
        $lastInputModule = $moduleInputs[CommunicationModule::FINAL_MODULE][array_key_first($moduleInputs[CommunicationModule::FINAL_MODULE])];

        foreach ($input->modules[CommunicationModule::BROADCASTER]->outputs as $start) {
            $flipFlopState = $emptyFlipFlopState;
            $conjunctionState = $emptyConjunctionState;
            $buttonPresses = 0;

            while (true) {
                /** @var \SplQueue<Pulse> $pulses */
                $pulses = new \SplQueue();
                $this->addPulse(
                    $pulses,
                    new CommunicationModule(CommunicationModule::BROADCASTER, ModuleType::Broadcaster, [$start]),
                    false
                );

                $buttonPresses++;

                while (!$pulses->isEmpty()) {
                    $pulse = $pulses->dequeue();
                    $name = $pulse->target;

                    if ($pulse->target === $lastInputModule && $pulse->highPulse) {
                        $counts[] = $buttonPresses;
                        continue 3;
                    }

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
            }
        }

        return Math::getLeastCommonMultiple($counts);
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
