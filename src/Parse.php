<?php

declare(strict_types=1);

namespace Riimu\AdventOfCode2023;

/**
 * @author Riikka Kalliomäki <riikka.kalliomaki@gmail.com>
 * @copyright Copyright (c) 2023 Riikka Kalliomäki
 * @license http://opensource.org/licenses/mit-license.php MIT License
 */
class Parse
{
    /**
     * @param string $input
     * @return array<int, string>
     */
    public static function lines(string $input): array
    {
        $lines = preg_split('/(\r\n|\r(?!\n)|(?<!\r)\n)/', trim($input), 0, PREG_SPLIT_NO_EMPTY);

        if (!\is_array($lines)) {
            throw new \UnexpectedValueException("Unexpected value returned from preg_split");
        }

        return $lines;
    }

    /**
     * @param string $input
     * @return array<string, string>
     */
    public static function namedSections(string $input): array
    {
        preg_match_all('/^(.*):/m', trim($input), $match, PREG_OFFSET_CAPTURE | PREG_SET_ORDER);

        $sections = [];

        foreach ($match as $index => $set) {
            $start = $set[0][1] + \strlen($set[0][0]);
            $end = $match[$index + 1][0][1] ?? \strlen($input);
            $sections[$set[1][0]] = trim(substr($input, $start, $end - $start));
        }

        return $sections;
    }

    public static function int(string $input): int
    {
        $integer = (int) $input;

        if ($input !== (string) $integer) {
            throw new \UnexpectedValueException("Unexpected integer value '$input'");
        }

        return $integer;
    }

    /**
     * @param string $input
     * @return array<int, int>
     */
    public static function ints(string $input): array
    {
        preg_match_all('/\d+/', $input, $match);
        return array_map(self::int(...), $match[0]);
    }
}
