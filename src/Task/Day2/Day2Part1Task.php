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
class Day2Part1Task implements TaskInterface
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
        $possible = [];
        $maxRed = 12;
        $maxGreen = 13;
        $maxBlue = 14;

        foreach ($input->games as $number => $game) {
            foreach ($game as $set) {
                if ($set->red > $maxRed || $set->green > $maxGreen || $set->blue > $maxBlue) {
                    continue 2;
                }
            }

            $possible[] = $number;
        }

        return (string)array_sum($possible);
    }

}
