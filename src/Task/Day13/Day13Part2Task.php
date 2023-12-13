<?php

declare(strict_types=1);

namespace Riimu\AdventOfCode2023\Task\Day13;

/**
 * @author Riikka Kalliomäki <riikka.kalliomaki@gmail.com>
 * @copyright Copyright (c) 2023 Riikka Kalliomäki
 * @license http://opensource.org/licenses/mit-license.php MIT License
 */
class Day13Part2Task extends AbstractDay13Task
{
    protected function isMirroredAt(array $lines, int $index): bool
    {
        $count = \count($lines);

        if ($index < 1) {
            return false;
        }

        $smudged = false;

        for ($i = $index; $i < $count; $i++) {
            $mirrored = $index - ($i - $index) - 1;

            if ($mirrored < 0) {
                break;
            }

            if ($lines[$i] !== $lines[$mirrored]) {
                if (!$smudged && $this->isSmudged($lines[$i], $lines[$mirrored])) {
                    $smudged = true;
                    continue;
                }

                return false;
            }
        }

        return $smudged;
    }

    /**
     * @param array<int, string> $line
     * @param array<int, string> $mirrored
     * @return bool
     */
    private function isSmudged(array $line, array $mirrored): bool
    {
        $smudged = false;

        foreach ($line as $key => $value) {
            if ($value !== $mirrored[$key]) {
                if (!$smudged) {
                    $smudged = true;
                    continue;
                }

                return false;
            }
        }

        return $smudged;
    }
}
