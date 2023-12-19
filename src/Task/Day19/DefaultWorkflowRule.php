<?php

declare(strict_types=1);

namespace Riimu\AdventOfCode2023\Task\Day19;

readonly class DefaultWorkflowRule
{
    public function __construct(
        public string $nextWorkflow
    ) {}
}
