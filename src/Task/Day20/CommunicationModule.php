<?php

declare(strict_types=1);

namespace Riimu\AdventOfCode2023\Task\Day20;

/**
 * @author Riikka Kalliomäki <riikka.kalliomaki@gmail.com>
 * @copyright Copyright (c) 2023 Riikka Kalliomäki
 * @license http://opensource.org/licenses/mit-license.php MIT License
 */
readonly class CommunicationModule
{
    public const BROADCASTER = 'broadcaster';
    public const FINAL_MODULE = 'rx';

    /**
     * @param string $name
     * @param ModuleType $type
     * @param array<int, string> $outputs
     */
    public function __construct(
        public string $name,
        public ModuleType $type,
        public array $outputs,
    ) {}
}
