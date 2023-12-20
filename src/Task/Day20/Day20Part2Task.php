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
        $lastInputModule = $this->findLastInputModule($input->modules);
        $counts = [];

        foreach ($input->modules[CommunicationModule::BROADCASTER]->outputs as $start) {
            $initialModule = new CommunicationModule(CommunicationModule::BROADCASTER, ModuleType::Broadcaster, [$start]);
            $buttonPresses = 0;
            $state = new ModuleState($input->modules);

            while (true) {
                $pulseQueue = new PulseQueue();
                $pulseQueue->enqueueOutput($initialModule, false);
                $buttonPresses++;

                while (!$pulseQueue->isEmpty()) {
                    $pulse = $pulseQueue->dequeue();

                    if ($pulse->target === $lastInputModule && $pulse->highPulse) {
                        $counts[] = $buttonPresses;
                        continue 3;
                    }

                    if (isset($input->modules[$pulse->target])) {
                        $this->processPulse($input->modules[$pulse->target], $pulse, $state, $pulseQueue);
                    }
                }
            }
        }

        return Math::getLeastCommonMultiple($counts);
    }

    /**
     * @param array<CommunicationModule> $modules
     * @return string
     */
    private function findLastInputModule(array $modules): string
    {
        foreach ($modules as $module) {
            if (\in_array(CommunicationModule::FINAL_MODULE, $module->outputs)) {
                return $module->name;
            }
        }

        return '';
    }
}
