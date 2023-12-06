<?php

declare(strict_types=1);

namespace Riimu\AdventOfCode2023\Task\Day6;

use Riimu\AdventOfCode2023\Parse;
use Riimu\AdventOfCode2023\TaskInterface;

/**
 * @author Riikka Kalliomäki <riikka.kalliomaki@gmail.com>
 * @copyright Copyright (c) 2023 Riikka Kalliomäki
 * @license http://opensource.org/licenses/mit-license.php MIT License
 * @implements TaskInterface<Day6Input>
 */
abstract class AbstractDay6Task implements TaskInterface
{
    final public function __construct() {}

    public static function createTask(): static
    {
        return new static();
    }

    public function parseInput(string $input): Day6Input
    {
        $sections = Parse::namedSections($input);

        return new Day6Input(Parse::ints($sections['Time']), Parse::ints($sections['Distance']));
    }

    protected static function calculateMinimum(int $time, int $distance): int
    {
        return (int) floor((-$time + sqrt($time ** 2 - 4 * -1 * -$distance)) / (2 * -1) + 1);
    }

    protected static function calculateMaximum(int $time, int $distance): int
    {
        return (int) ceil((-$time - sqrt($time ** 2 - 4 * -1 * -$distance)) / (2 * -1) - 1);
    }
}
