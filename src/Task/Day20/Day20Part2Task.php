<?php

declare(strict_types=1);

namespace Riimu\AdventOfCode2023\Task\Day20;

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

        $functions = [];
        $indent2 = str_repeat(' ', 4 * 2);
        $indent3 = str_repeat(' ', 4 * 3);
        $indent4 = str_repeat(' ', 4 * 4);

        foreach ($input->modules as $module) {
            $highSignals = implode("\n$indent3", array_map(fn(string $x): string => $this->makeSignal($module, true, $input->modules[$x] ?? null), $module->outputs));
            $lowSignals = implode("\n$indent2", array_map(fn(string $x): string => $this->makeSignal($module, false, $input->modules[$x] ?? null), $module->outputs));

            if ($module->type === ModuleType::FlipFlop) {
                $functions[$module->name] = <<<PHP
                        public function $module->name(bool \$signal): void
                        {
                            static \$state = false;

                            if (\$signal) {
                                return;
                            }

                            \$state = !\$state;

                            if (\$state) {
                                $highSignals
                                return;
                            }

                            $lowSignals
                        }
                    PHP;
            } elseif ($module->type === ModuleType::Conjuction) {
                $state = implode(', ', array_map(static fn(string $x): string => sprintf("'%s' => null", $x), $moduleInputs[$module->name]));
                $condition = implode(', ', array_map(static fn(string $x): string => sprintf("\$state['%s']", $x), $moduleInputs[$module->name]));

                $functions[$module->name] = <<<PHP
                        public function $module->name(bool \$signal, string \$from): void
                        {
                            static \$state = [$state];

                            \$state[\$from] = \$signal ? true : null;

                            if (!isset($condition)) {
                                $highSignals
                                return;
                            }

                            $lowSignals
                        }
                    PHP;
            }
        }

        $broadcast = implode(
            "\n$indent4",
            array_map(
                fn(string $x): string => $this->makeSignal($input->modules[CommunicationModule::BROADCASTER], false, $input->modules[$x]),
                $input->modules[CommunicationModule::BROADCASTER]->outputs
            )
        );

        $allFunctions = implode("\n\n", $functions);

        $file = <<<PHP
        <?php
        
        declare(strict_types=1);
        
        namespace Riimu\AdventOfCode2023\Task\Day20;
        
        (new Test())->broadcast();
        
        class Test
        {
            /** @var \SplQueue<\Closure> */
            public \SplQueue \$queue;

            public function broadcast(): void
            {
                \$this->queue = new \SplQueue();
                \$buttonPresses = 0;
        
                try {
                    while (true) {
                        \$buttonPresses++;

                        $broadcast

                        while (!\$this->queue->isEmpty()) {
                            \$this->queue->dequeue()();
                        }
                    }
                } catch (\Throwable \$exception) {
                    echo \$buttonPresses . PHP_EOL;
                    echo \$exception;
                }
            }

            public function rx(bool \$signal): void
            {
                if (!\$signal) {
                    throw new \RuntimeException('We did it!');
                }
            }

        $allFunctions
        }
        
        PHP;

        file_put_contents(__DIR__ . '/Test.php', $file);

        return 0;
    }

    private function makeSignal(CommunicationModule $from, bool $signal, ?CommunicationModule $to): string
    {
        if ($to === null) {
            return sprintf('$this->queue->enqueue(fn() => $this->rx(%s));', var_export($signal, true));
        }

        if ($to->type === ModuleType::FlipFlop) {
            return sprintf('$this->queue->enqueue(fn() => $this->%s(%s));', $to->name, var_export($signal, true));
        }

        return sprintf('$this->queue->enqueue(fn() => $this->%s(%s, %s));', $to->name, var_export($signal, true), var_export($from->name, true));
    }
}
