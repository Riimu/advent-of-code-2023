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
    private const MAX_ITERATIONS = 1000;

    protected function solve(Day20Input $input): int
    {
        $state = new ModuleState($input->modules);
        $previousStates = [];
        $currentState = $state->getKey();

        for ($i = 0; $i < self::MAX_ITERATIONS; $i++) {
            $pulseQueue = new PulseQueue();
            $pulseQueue->enqueueOutput($input->modules[CommunicationModule::BROADCASTER], false);
            $pulseCount = [1, 0];

            while (!$pulseQueue->isEmpty()) {
                $pulse = $pulseQueue->dequeue();
                $pulseCount[$pulse->highPulse ? 1 : 0]++;

                if (isset($input->modules[$pulse->target])) {
                    $this->processPulse($input->modules[$pulse->target], $pulse, $state, $pulseQueue);
                }
            }

            $previousStates[$currentState] = $pulseCount;
            $currentState = $state->getKey();

            if (\array_key_exists($currentState, $previousStates)) {
                break;
            }
        }

        $loops = self::MAX_ITERATIONS / \count($previousStates);
        $lowPulses = array_sum(array_column($previousStates, 0));
        $highPulses = array_sum(array_column($previousStates, 1));

        return (int) ($lowPulses * $highPulses * $loops * $loops);
    }
}
