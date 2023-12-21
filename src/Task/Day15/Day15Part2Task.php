<?php

declare(strict_types=1);

namespace Riimu\AdventOfCode2023\Task\Day15;

use Riimu\AdventOfCode2023\Utility\Parse;

/**
 * @author Riikka Kalliomäki <riikka.kalliomaki@gmail.com>
 * @copyright Copyright (c) 2023 Riikka Kalliomäki
 * @license http://opensource.org/licenses/mit-license.php MIT License
 */
class Day15Part2Task extends AbstractDay15Task
{
    private const COMMAND_REMOVE = '-';
    private const COMMAND_PUT = '=';

    protected function solve(Day15Input $input): int
    {
        $boxes = array_fill(0, 256, []);

        foreach ($input->operations as $operation) {
            if (!preg_match('/^([a-z]+)([-=])(\d+)?$/', $operation, $match, \PREG_UNMATCHED_AS_NULL)) {
                throw new \RuntimeException("Invalid operation '$operation'");
            }

            [, $label, $command, $value] = $match;
            $box = $this->calculateHash((string) $label);

            switch ($command) {
                case self::COMMAND_REMOVE:
                    unset($boxes[$box][$label]);
                    break;
                case self::COMMAND_PUT:
                    $boxes[$box][$label] = Parse::int((string) $value);
                    break;
                default:
                    throw new \RuntimeException("Unknown command '$command'");
            }
        }

        $focusingPowers = [];

        foreach ($boxes as $number => $box) {
            $power = 0;

            foreach (array_values($box) as $position => $focalLength) {
                $power += ($number + 1) * ($position + 1) * $focalLength;
            }

            $focusingPowers[] = $power;
        }

        return array_sum($focusingPowers);
    }
}
