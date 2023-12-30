<?php

declare(strict_types=1);

namespace Riimu\AdventOfCode2023\Task\Day20;

/**
 * @author Riikka Kalliomäki <riikka.kalliomaki@gmail.com>
 * @copyright Copyright (c) 2023 Riikka Kalliomäki
 * @license http://opensource.org/licenses/mit-license.php MIT License
 */
class ModuleState
{
    /** @var array<string, bool> */
    public array $flipFlops;

    /** @var array<string, array<string, bool>> */
    public array $conjunctions;

    /**
     * @param array<CommunicationModule> $modules
     */
    public function __construct(array $modules)
    {
        $this->flipFlops = [];
        $this->conjunctions = [];

        $inputs = [];

        foreach ($modules as $module) {
            foreach ($module->outputs as $name) {
                $inputs[$name][] = $module->name;
            }
        }

        foreach ($modules as $module) {
            if ($module->type === ModuleType::FlipFlop) {
                $this->flipFlops[$module->name] = false;
            } elseif ($module->type === ModuleType::Conjunction) {
                $this->conjunctions[$module->name] = array_fill_keys($inputs[$module->name], false);
            }
        }
    }

    public function getKey(): string
    {
        return sprintf(
            '%s-%s',
            implode('', array_map(intval(...), $this->flipFlops)),
            implode('', array_map(static fn(array $x): string => implode('', array_map(intval(...), $x)), $this->conjunctions))
        );
    }
}
