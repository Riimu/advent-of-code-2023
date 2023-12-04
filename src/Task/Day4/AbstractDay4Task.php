<?php

declare(strict_types=1);

namespace Riimu\AdventOfCode2023\Task\Day4;

use Riimu\AdventOfCode2023\TaskInterface;

/**
 * @author Riikka Kalliomäki <riikka.kalliomaki@gmail.com>
 * @copyright Copyright (c) 2023 Riikka Kalliomäki
 * @license http://opensource.org/licenses/mit-license.php MIT License
 * @implements TaskInterface<Day4Input>
 */
abstract class AbstractDay4Task implements TaskInterface
{
    public function parseInput(string $input): Day4Input
    {
        $lines = preg_split('/[\r\n]+/', trim($input));
        $cards = [];

        foreach ($lines as $line) {
            [, $winners, $numbers] = preg_split('/[:|]/', $line);
            $cards[] = new ScratchCard(
                array_map(static fn(string $x): int => (int) $x, preg_split('/\s+/', $winners, 0, PREG_SPLIT_NO_EMPTY)),
                array_map(static fn(string $x): int => (int) $x, preg_split('/\s+/', $numbers, 0, PREG_SPLIT_NO_EMPTY)),
            );
        }

        return new Day4Input($cards);
    }
}
