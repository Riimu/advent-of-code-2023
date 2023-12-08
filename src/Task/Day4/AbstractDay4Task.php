<?php

declare(strict_types=1);

namespace Riimu\AdventOfCode2023\Task\Day4;

use Riimu\AdventOfCode2023\TaskInputInterface;
use Riimu\AdventOfCode2023\TaskInterface;
use Riimu\AdventOfCode2023\Utility\Parse;

/**
 * @author Riikka Kalliomäki <riikka.kalliomaki@gmail.com>
 * @copyright Copyright (c) 2023 Riikka Kalliomäki
 * @license http://opensource.org/licenses/mit-license.php MIT License
 */
abstract class AbstractDay4Task implements TaskInterface
{
    final public function __construct() {}

    public static function createTask(): static
    {
        return new static();
    }

    public function parseInput(string $input): Day4Input
    {
        $sections = Parse::namedSections($input);
        $cards = [];

        foreach ($sections as $section) {
            [$winners, $numbers] = explode('|', $section);
            $cards[] = new ScratchCard(Parse::ints($winners), Parse::ints($numbers));
        }

        return new Day4Input($cards);
    }

    public function solveTask(TaskInputInterface $input): string
    {
        if (!$input instanceof Day4Input) {
            throw new \InvalidArgumentException(sprintf("Unexpected input type '%s'", get_debug_type($input)));
        }

        return (string) $this->solve($input);
    }

    abstract protected function solve(Day4Input $input): int;
}
