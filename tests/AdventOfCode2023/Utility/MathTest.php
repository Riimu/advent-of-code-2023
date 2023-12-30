<?php

declare(strict_types=1);

namespace AdventOfCode2023\Utility;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Riimu\AdventOfCode2023\Utility\Math;

/**
 * @author Riikka Kalliomäki <riikka.kalliomaki@gmail.com>
 * @copyright Copyright (c) 2023 Riikka Kalliomäki
 * @license http://opensource.org/licenses/mit-license.php MIT License
 */
class MathTest extends TestCase
{
    /**
     * @param array<int, int> $numbers
     * @param int $multiple
     * @return void
     */
    #[DataProvider('provideGetLeastCommonMultipleTests')]
    public function testGetLeastCommonMultiple(array $numbers, int $multiple): void
    {
        $this->assertSame($multiple, Math::getLeastCommonMultiple($numbers));
    }

    /**
     * @return iterable<int, array<int, array<int,int>|int>>
     */
    public static function provideGetLeastCommonMultipleTests(): iterable
    {
        return [
            [[4, 6], 12],
            [[21, 6], 42],
            [[8, 9, 21], 504],
            [[4, 7, 12, 21, 42], 84],
            [[11, 13, 15, 17], 36465],
        ];
    }

    /**
     * @param int $number
     * @param array<int, int> $expectedFactors
     * @return void
     */
    #[DataProvider('provideGetFactorsTests')]
    public function testGetFactors(int $number, array $expectedFactors): void
    {
        $this->assertSame($expectedFactors, Math::getFactors($number));
    }

    /**
     * @return iterable<int, array<int, array<int,int>|int>>
     */
    public static function provideGetFactorsTests(): iterable
    {
        return [
            [12, [2 => 2, 3 => 1]],
            [147, [3 => 1, 7 => 2]],
            [90, [2 => 1, 3 => 2, 5 => 1]],
            [48, [2 => 4, 3 => 1]],
            [330, [2 => 1, 3 => 1, 5 => 1, 11 => 1]],
            [17, [17 => 1]],
        ];
    }

    public function testGetPrimes(): void
    {
        $primes = file_get_contents(__DIR__ . '/../../data/prime-list-10000.txt');

        if (!\is_string($primes)) {
            $this->fail('Failed to read contents of the primes test file');
        }

        $expectedPrimes = array_map(
            static fn(string $x): int => (int) $x,
            preg_split('/\s+/', $primes, 0, \PREG_SPLIT_NO_EMPTY) ?: []
        );

        $this->assertCount(10000, $expectedPrimes);

        $expectedCount = \count($expectedPrimes);
        $actualPrimes = [];

        foreach (Math::getPrimes() as $prime) {
            $actualPrimes[] = $prime;

            if (\count($actualPrimes) === $expectedCount) {
                break;
            }
        }

        $this->assertSame($expectedPrimes, $actualPrimes);
    }
}
