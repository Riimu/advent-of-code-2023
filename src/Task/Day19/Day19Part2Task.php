<?php

declare(strict_types=1);

namespace Riimu\AdventOfCode2023\Task\Day19;

/**
 * @author Riikka Kalliomäki <riikka.kalliomaki@gmail.com>
 * @copyright Copyright (c) 2023 Riikka Kalliomäki
 * @license http://opensource.org/licenses/mit-license.php MIT License
 */
class Day19Part2Task extends AbstractDay19Task
{
    protected function solve(Day19Input $input): int
    {
        $processRanges = [[Workflow::WORKFLOW_START, array_fill_keys(['x', 'm', 'a', 's'], [1, 4000])]];
        $acceptedRanges = [];

        while ($processRanges !== []) {
            [$workflow, $ranges] = array_pop($processRanges);

            if ($workflow === Workflow::WORKFLOW_ACCEPTED) {
                $acceptedRanges[] = $ranges;
                continue;
            }

            if ($workflow === Workflow::WORKFLOW_REJECTED) {
                continue;
            }

            foreach ($input->workflows[$workflow]->rules as $rule) {
                if ($rule instanceof DefaultWorkflowRule) {
                    $processRanges[] = [$rule->nextWorkflow, $ranges];
                    break;
                }

                $rating = $ranges[$rule->ratingName];

                if ($rule->operator === Operator::LESS_THAN) {
                    if ($rating[0] < $rule->value) {
                        $ranges[$rule->ratingName] = [$rule->value, $rating[1]];
                        $processRanges[] = [$rule->nextWorkflow, array_replace(
                            $ranges,
                            [$rule->ratingName => [$rating[0], min($rule->value - 1, $rating[1])]]
                        )];
                    }

                    if ($rating[1] < $rule->value) {
                        break;
                    }

                    continue;
                }

                if ($rating[1] > $rule->value) {
                    $ranges[$rule->ratingName] = [$rating[0], $rule->value];
                    $processRanges[] = [$rule->nextWorkflow, array_replace(
                        $ranges,
                        [$rule->ratingName => [max($rule->value + 1, $rating[0]), $rating[1]]]
                    )];
                }

                if ($rating[0] > $rule->value) {
                    break;
                }
            }
        }

        return array_sum(array_map(
            static fn(array $ranges): int => (int) array_product(array_map(
                static fn(array $range): int => $range[1] - $range[0] + 1,
                $ranges
            )),
            $acceptedRanges
        ));
    }
}
