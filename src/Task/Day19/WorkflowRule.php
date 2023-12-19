<?php

declare(strict_types=1);

namespace Riimu\AdventOfCode2023\Task\Day19;

readonly class WorkflowRule
{
    public const OPERATOR_GREATER_THAN = '>';
    public const OEPRATOR_LESS_THAN = '<';

    public function __construct(
        public string $ratingName,
        public Operator $operator,
        public int $value,
        public string $nextWorkflow,
    ) {}
}
