<?php

declare(strict_types=1);

namespace Riimu\AdventOfCode2023\Task\Day13;

/**
 * @author Riikka Kalliomäki <riikka.kalliomaki@gmail.com>
 * @copyright Copyright (c) 2023 Riikka Kalliomäki
 * @license http://opensource.org/licenses/mit-license.php MIT License
 */
class Day13Part1Task extends AbstractDay13Task
{
    protected function isMirroredAt(array $lines, int $index): bool
    {
        $count = \count($lines);

        if ($index < 1) {
            return false;
        }

        for ($i = $index; $i < $count; $i++) {
            $mirrored = $index - ($i - $index) - 1;

            if ($mirrored < 0) {
                break;
            }

            if ($lines[$i] !== $lines[$mirrored]) {
                return false;
            }
        }

        return true;
    }
}
