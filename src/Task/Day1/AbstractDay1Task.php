<?php

declare(strict_types=1);

namespace Riimu\AdventOfCode2023\Task\Day1;

use Riimu\AdventOfCode2023\TaskInputInterface;
use Riimu\AdventOfCode2023\TaskInterface;
use Riimu\AdventOfCode2023\Utility\Parse;

/**
 * @author Riikka Kalliomäki <riikka.kalliomaki@gmail.com>
 * @copyright Copyright (c) 2023 Riikka Kalliomäki
 * @license http://opensource.org/licenses/mit-license.php MIT License
 */
abstract class AbstractDay1Task implements TaskInterface
{
    /** @var array<string|int, int> */
    private readonly array $digits;
    private readonly string $digitPattern;

    /**
     * @param array<string|int, int> $digits
     */
    final public function __construct(array $digits)
    {
        $this->digits = $digits;
        $this->digitPattern = implode('|', array_map(
            static fn(string|int $x): string => preg_quote((string) $x, '/'),
            array_keys($digits)
        ));
    }

    public function parseInput(string $input): Day1Input
    {
        return new Day1Input(Parse::lines($input));
    }

    public function solveTask(TaskInputInterface $input): string
    {
        if (!$input instanceof Day1Input) {
            throw new \InvalidArgumentException(sprintf("Unexpected input type '%s'", get_debug_type($input)));
        }

        return (string) $this->solve($input);
    }

    protected function solve(Day1Input $input): int
    {
        $calibrationValues = [];

        foreach ($input->lines as $line) {
            $firstDigit = $this->findFirstDigit($line);
            $lastDigit = $this->findLastDigit($line);

            $calibrationValues[] = $firstDigit === 0
                ? $lastDigit
                : $firstDigit * 10 + $lastDigit;
        }

        return array_sum($calibrationValues);
    }

    public function findFirstDigit(string $line): int
    {
        preg_match(sprintf('/%s/', $this->digitPattern), $line, $match);

        return $this->digits[$match[0]];
    }

    public function findLastDigit(string $line): int
    {
        preg_match(sprintf('/.*(%s)/', $this->digitPattern), $line, $match);

        return $this->digits[$match[1]];
    }
}
