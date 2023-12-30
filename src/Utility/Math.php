<?php

declare(strict_types=1);

namespace Riimu\AdventOfCode2023\Utility;

/**
 * @author Riikka Kalliomäki <riikka.kalliomaki@gmail.com>
 * @copyright Copyright (c) 2023 Riikka Kalliomäki
 * @license http://opensource.org/licenses/mit-license.php MIT License
 */
class Math
{
    /** @var array<int, int> */
    private static array $primes = [3];

    /**
     * @param array<int, int> $numbers
     * @return int
     */
    public static function getLeastCommonMultiple(array $numbers): int
    {
        $maxFactors = [];

        foreach ($numbers as $number) {
            foreach (self::getFactors($number) as $factor => $count) {
                $maxFactors[$factor] = max($maxFactors[$factor] ?? 0, $factor ** $count);
            }
        }

        return (int) array_product($maxFactors);
    }

    /**
     * @param int $number
     * @return array<int, int>
     */
    public static function getFactors(int $number): array
    {
        $factors = [];
        $squareRoot = (int) sqrt($number);

        foreach (self::getPrimes() as $prime) {
            if ($prime > $squareRoot) {
                break;
            }

            if ($number % $prime === 0) {
                $count = 1;
                $divisor = $prime;

                while ($number % ($divisor * $prime) === 0) {
                    $count++;
                    $divisor *= $prime;
                }

                if ($number === $divisor) {
                    return $factors + [$prime => $count];
                }

                $factors[$prime] = $count;
                $number = intdiv($number, $divisor);
                $squareRoot = (int) sqrt($number);
            }
        }

        return $factors + [$number => 1];
    }

    /**
     * @return iterable<int, int>
     */
    public static function getPrimes(): iterable
    {
        yield 2;

        for ($i = 0; true; $i++) {
            if (\array_key_exists($i, self::$primes)) {
                yield self::$primes[$i];
                continue;
            }

            $test = self::$primes[$i - 1];

            while (true) {
                $test += 2;
                $squareRoot = (int) sqrt($test);

                foreach (self::$primes as $prime) {
                    if ($test % $prime === 0) {
                        continue 2;
                    }

                    if ($prime > $squareRoot) {
                        break;
                    }
                }

                self::$primes[$i] = $test;
                yield $test;
                break;
            }
        }
    }
}
