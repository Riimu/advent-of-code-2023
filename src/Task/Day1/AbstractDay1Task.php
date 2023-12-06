<?php

declare(strict_types=1);

namespace Riimu\AdventOfCode2023\Task\Day1;

use Riimu\AdventOfCode2023\Parse;
use Riimu\AdventOfCode2023\TaskInputInterface;
use Riimu\AdventOfCode2023\TaskInterface;

/**
 * @author Riikka Kalliomäki <riikka.kalliomaki@gmail.com>
 * @copyright Copyright (c) 2023 Riikka Kalliomäki
 * @license http://opensource.org/licenses/mit-license.php MIT License
 * @implements TaskInterface<Day1Input>
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

    public function parseInput(string $input): TaskInputInterface
    {
        return new Day1Input(Parse::lines($input));
    }

    public function solveTask(TaskInputInterface $input): string
    {
        $calibrationValues = [];

        foreach ($input->lines as $line) {
            $firstDigit = $this->findFirstDigit($line);
            $lastDigit = $this->findLastDigit($line);

            $calibrationValues[] = $firstDigit === 0
                ? $lastDigit
                : $firstDigit * 10 + $lastDigit;
        }

        return (string) array_sum($calibrationValues);
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
