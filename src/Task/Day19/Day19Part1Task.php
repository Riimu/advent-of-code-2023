<?php

declare(strict_types=1);

namespace Riimu\AdventOfCode2023\Task\Day19;

/**
 * @author Riikka Kalliomäki <riikka.kalliomaki@gmail.com>
 * @copyright Copyright (c) 2023 Riikka Kalliomäki
 * @license http://opensource.org/licenses/mit-license.php MIT License
 */
class Day19Part1Task extends AbstractDay19Task
{
    protected function solve(Day19Input $input): int
    {
        $totalRatings = [];

        foreach ($input->parts as $part) {
            $workflow = Workflow::WORKFLOW_START;

            do {
                foreach ($input->workflows[$workflow]->rules as $rule) {
                    if ($this->ruleMatches($rule, $part)) {
                        $workflow = $rule->nextWorkflow;
                        break;
                    }
                }
            } while ($workflow !== Workflow::WORKFLOW_ACCEPTED && $workflow !== Workflow::WORKFLOW_REJECTED);

            if ($workflow === Workflow::WORKFLOW_ACCEPTED) {
                $totalRatings[] = array_sum($part->ratings);
            }
        }

        return array_sum($totalRatings);
    }

    protected function ruleMatches(WorkflowRule|DefaultWorkflowRule $rule, MachinePart $part): bool
    {
        if ($rule instanceof DefaultWorkflowRule) {
            return true;
        }

        return $rule->operator === Operator::GREATER_THAN
            ? $part->ratings[$rule->ratingName] > $rule->value
            : $part->ratings[$rule->ratingName] < $rule->value;
    }
}
