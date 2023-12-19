<?php

declare(strict_types=1);

namespace Riimu\AdventOfCode2023\Task\Day19;

/**
 * @author Riikka Kalliomäki <riikka.kalliomaki@gmail.com>
 * @copyright Copyright (c) 2023 Riikka Kalliomäki
 * @license http://opensource.org/licenses/mit-license.php MIT License
 */
readonly class Workflow
{
    public const WORKFLOW_START = 'in';
    public const WORKFLOW_ACCEPTED = 'A';
    public const WORKFLOW_REJECTED = 'R';

    /**
     * @param array<int, WorkflowRule|DefaultWorkflowRule> $rules
     */
    public function __construct(
        public array $rules
    ) {}
}
