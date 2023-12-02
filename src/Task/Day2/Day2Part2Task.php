<?php

declare(strict_types=1);

namespace Riimu\AdventOfCode2023\Task\Day2;

use Riimu\AdventOfCode2023\TaskInputInterface;
use Riimu\AdventOfCode2023\TaskInterface;

/**
 * @author Riikka Kalliomäki <riikka.kalliomaki@gmail.com>
 * @copyright Copyright (c) 2023 Riikka Kalliomäki
 * @license http://opensource.org/licenses/mit-license.php MIT License
 * @implements TaskInterface<Day2Input>
 */
class Day2Part2Task implements TaskInterface
{
    public static function createTask(): static
    {
        return new self();
    }

    public function parseInput(string $input): TaskInputInterface
    {
        $lines = preg_split('/[\r\n]+/', trim($input));
        $games = [];

        foreach ($lines as $line) {
            if (!preg_match('/Game (\d+):(.*)/', $line, $lineMatch)) {
                throw new \RuntimeException(sprintf("Unexpected line input '%s'", $line));
            }

            $gameNumber = (int)$lineMatch[1];
            $sets = [];

            foreach (explode(';', $lineMatch[2]) as $lineSet) {
                preg_match_all('/(\d+) (red|green|blue)/', $lineSet, $setMatches, PREG_SET_ORDER);
                $colors = [];

                foreach ($setMatches as $setMatch) {
                    $colors[$setMatch[2]] = (int)$setMatch[1];
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
        $powers = [];

        foreach ($input->games as $number => $game) {
            $minRed = 0;
            $minGreen = 0;
            $minBlue = 0;

            foreach ($game as $set) {
                $minRed = max($minRed, $set->red);
                $minGreen = max($minGreen, $set->green);
                $minBlue = max($minBlue, $set->blue);
            }

            $powers[] = $minRed * $minGreen * $minBlue;
        }

        return (string)array_sum($powers);
    }

}
