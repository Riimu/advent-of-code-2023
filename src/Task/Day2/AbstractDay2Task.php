<?php

declare(strict_types=1);

namespace Riimu\AdventOfCode2023\Task\Day2;

use Riimu\AdventOfCode2023\TaskInputInterface;
use Riimu\AdventOfCode2023\TaskInterface;
use Riimu\AdventOfCode2023\Utility\Parse;

/**
 * @author Riikka Kalliomäki <riikka.kalliomaki@gmail.com>
 * @copyright Copyright (c) 2023 Riikka Kalliomäki
 * @license http://opensource.org/licenses/mit-license.php MIT License
 */
abstract class AbstractDay2Task implements TaskInterface
{
    final public function __construct() {}

    public static function createTask(): static
    {
        return new static();
    }

    public function parseInput(string $input): Day2Input
    {
        $sections = Parse::namedSections($input);
        $games = [];

        foreach ($sections as $name => $data) {
            $gameNumber = Parse::ints($name)[0];
            $sets = [];

            foreach (explode(';', $data) as $lineSet) {
                preg_match_all('/(\d+) (red|green|blue)/', $lineSet, $setMatches, \PREG_SET_ORDER);
                $colors = [];

                foreach ($setMatches as $setMatch) {
                    $colors[$setMatch[2]] = Parse::int($setMatch[1]);
                }

                $sets[] = new GameSet(
                    $colors['red'] ?? 0,
                    $colors['green'] ?? 0,
                    $colors['blue'] ?? 0,
                );
            }

            $games[$gameNumber] = $sets;
        }

        return new Day2Input($games);
    }

    public function solveTask(TaskInputInterface $input): string
    {
        if (!$input instanceof Day2Input) {
            throw new \InvalidArgumentException(sprintf("Unexpected input type '%s'", get_debug_type($input)));
        }

        return (string) $this->solve($input);
    }

    abstract protected function solve(Day2Input $input): int;
}
