<?php

declare(strict_types=1);

namespace Riimu\AdventOfCode2023\Task\Day20;

/**
 * @author Riikka Kalliomäki <riikka.kalliomaki@gmail.com>
 * @copyright Copyright (c) 2023 Riikka Kalliomäki
 * @license http://opensource.org/licenses/mit-license.php MIT License
 * @extends \SplQueue<Pulse>
 */
class PulseQueue extends \SplQueue
{
    public function enqueueOutput(CommunicationModule $module, bool $highPulse): void
    {
        foreach ($module->outputs as $output) {
            $this->enqueue(new Pulse($module->name, $output, $highPulse));
        }
    }
}
