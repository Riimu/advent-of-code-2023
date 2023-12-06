<?php

declare(strict_types=1);

namespace Riimu\AdventOfCode2023\Task\Day6;

use Riimu\AdventOfCode2023\Parse;
use Riimu\AdventOfCode2023\TaskInputInterface;
use Riimu\AdventOfCode2023\TaskInterface;

/**
 * @author Riikka Kalliomäki <riikka.kalliomaki@gmail.com>
 * @copyright Copyright (c) 2023 Riikka Kalliomäki
 * @license http://opensource.org/licenses/mit-license.php MIT License
 * @implements TaskInterface<Day6Input>
 */
class Day6Part1Task implements TaskInterface
{
    public static function createTask(): static
    {
        return new self();
    }

    public function parseInput(string $input): Day6Input
    {
        $sections = Parse::namedSections($input);

        return new Day6Input(Parse::ints($sections['Time']), Parse::ints($sections['Distance']));
    }

    public function solveTask(TaskInputInterface $input): string
    {
        $winCounts = [];

        foreach ($input->times as $game => $time) {
            $minimum = 0;
            $maximum = 0;

            for ($i = 1; $i < $time; $i++) {
                if (($time - $i) * $i > $input->distances[$game]) {
                    $minimum = $i;
                    break;
                }
            }

            for ($i = $time - 1; $i > 0; $i--) {
                if (($time - $i) * $i > $input->distances[$game]) {
                    $maximum = $i;
                    break;
                }
            }

            $winCounts[] = $maximum - $minimum + 1;
        }

        return (string) array_product($winCounts);
    }

}
