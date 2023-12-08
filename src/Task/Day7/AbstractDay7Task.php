<?php

declare(strict_types=1);

namespace Riimu\AdventOfCode2023\Task\Day7;

use Riimu\AdventOfCode2023\TaskInputInterface;
use Riimu\AdventOfCode2023\TaskInterface;
use Riimu\AdventOfCode2023\Utility\Parse;

/**
 * @author Riikka Kalliomäki <riikka.kalliomaki@gmail.com>
 * @copyright Copyright (c) 2023 Riikka Kalliomäki
 * @license http://opensource.org/licenses/mit-license.php MIT License
 */
abstract class AbstractDay7Task implements TaskInterface
{
    final public function __construct() {}

    public static function createTask(): static
    {
        return new static();
    }

    public function parseInput(string $input): Day7Input
    {
        $lines = Parse::lines($input);
        $hands = [];

        foreach ($lines as $line) {
            $data = explode(' ', $line);
            $hands[] = new Hand($data[0], Parse::int($data[1]));
        }

        return new Day7Input($hands);
    }

    public function solveTask(TaskInputInterface $input): string
    {
        if (!$input instanceof Day7Input) {
            throw new \InvalidArgumentException(sprintf("Unexpected input type '%s'", get_debug_type($input)));
        }

        return (string) $this->solve($input);
    }

    protected function solve(Day7Input $input): int
    {
        $values = [];

        foreach ($input->hands as $key => $hand) {
            $values[$key] = sprintf(
                '%d%s',
                $this->calculateStrength($hand->hand),
                $this->getSortValue($hand->hand)
            );
        }

        $order = array_keys($input->hands);
        usort($order, static fn(int $a, int $b): int => strcasecmp($values[$a], $values[$b]));

        $total = 0;
        $rank = 1;

        foreach ($order as $key) {
            $total += $input->hands[$key]->bid * $rank++;
        }

        return $total;
    }

    private function calculateStrength(string $hand): int
    {
        return match ($this->countCards($hand)) {
            [5] => 7,
            [4, 1] => 6,
            [3, 2] => 5,
            [3, 1, 1] => 4,
            [2, 2, 1] => 3,
            [2, 1, 1, 1] => 2,
            default => 1,
        };
    }

    /**
     * @param string $hand
     * @return array<int, int>
     */
    abstract protected function countCards(string $hand): array;

    abstract protected function getSortValue(string $hand): string;
}
