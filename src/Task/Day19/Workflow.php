<?php

declare(strict_types=1);

namespace Riimu\AdventOfCode2023\Task\Day19;

class Workflow
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
