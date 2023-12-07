<?php

declare(strict_types=1);

namespace Riimu\AdventOfCode2023\Test;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Riimu\AdventOfCode2023\Task;
use Riimu\AdventOfCode2023\TaskInterface;

/**
 * @author Riikka Kalliomäki <riikka.kalliomaki@gmail.com>
 * @copyright Copyright (c) 2023 Riikka Kalliomäki
 * @license http://opensource.org/licenses/mit-license.php MIT License
 */
class TaskResultTest extends TestCase
{
    /**
     * @param class-string<TaskInterface> $taskClass
     * @param string $inputFile
     * @param string $result
     * @return void
     */
    #[DataProvider('resultTestProvider')]
    public function testTaskResults(string $taskClass, string $inputFile, string $result): void
    {
        $contents = file_get_contents($inputFile);

        if (!\is_string($contents)) {
            $this->fail("Could not read contents of the input file '$inputFile'");
        }
        $task = $taskClass::createTask();
        $input = $task->parseInput($contents);

        $this->assertSame($result, $task->solveTask($input));
    }

    /**
     * @return iterable<array<int, string>>
     */
    public static function resultTestProvider(): iterable
    {
        return [
            [Task\Day1\Day1Part1Task::class, __DIR__ . '/../../input/day-1-sample-1.txt', '142'],
            [Task\Day1\Day1Part1Task::class, __DIR__ . '/../../input/day-1-input.txt', '55090'],
            [Task\Day1\Day1Part2Task::class, __DIR__ . '/../../input/day-1-sample-2.txt', '281'],
            [Task\Day1\Day1Part2Task::class, __DIR__ . '/../../input/day-1-input.txt', '54845'],

            [Task\Day2\Day2Part1Task::class, __DIR__ . '/../../input/day-2-sample-1.txt', '8'],
            [Task\Day2\Day2Part1Task::class, __DIR__ . '/../../input/day-2-input.txt', '2810'],
            [Task\Day2\Day2Part2Task::class, __DIR__ . '/../../input/day-2-sample-1.txt', '2286'],
            [Task\Day2\Day2Part2Task::class, __DIR__ . '/../../input/day-2-input.txt', '69110'],

            [Task\Day3\Day3Part1Task::class, __DIR__ . '/../../input/day-3-sample-1.txt', '4361'],
            [Task\Day3\Day3Part1Task::class, __DIR__ . '/../../input/day-3-input.txt', '535351'],
            [Task\Day3\Day3Part2Task::class, __DIR__ . '/../../input/day-3-sample-1.txt', '467835'],
            [Task\Day3\Day3Part2Task::class, __DIR__ . '/../../input/day-3-input.txt', '87287096'],

            [Task\Day4\Day4Part1Task::class, __DIR__ . '/../../input/day-4-sample-1.txt', '13'],
            [Task\Day4\Day4Part1Task::class, __DIR__ . '/../../input/day-4-input.txt', '19855'],
            [Task\Day4\Day4Part2Task::class, __DIR__ . '/../../input/day-4-sample-1.txt', '30'],
            [Task\Day4\Day4Part2Task::class, __DIR__ . '/../../input/day-4-input.txt', '10378710'],

            [Task\Day5\Day5Part1Task::class, __DIR__ . '/../../input/day-5-sample-1.txt', '35'],
            [Task\Day5\Day5Part1Task::class, __DIR__ . '/../../input/day-5-input.txt', '621354867'],
            [Task\Day5\Day5Part2Task::class, __DIR__ . '/../../input/day-5-sample-1.txt', '46'],
            [Task\Day5\Day5Part2Task::class, __DIR__ . '/../../input/day-5-input.txt', '15880236'],

            [Task\Day6\Day6Part1Task::class, __DIR__ . '/../../input/day-6-sample-1.txt', '288'],
            [Task\Day6\Day6Part1Task::class, __DIR__ . '/../../input/day-6-input.txt', '128700'],
            [Task\Day6\Day6Part2Task::class, __DIR__ . '/../../input/day-6-sample-1.txt', '71503'],
            [Task\Day6\Day6Part2Task::class, __DIR__ . '/../../input/day-6-input.txt', '39594072'],

            [Task\Day7\Day7Part1Task::class, __DIR__ . '/../../input/day-7-sample-1.txt', '6440'],
            [Task\Day7\Day7Part1Task::class, __DIR__ . '/../../input/day-7-input.txt', '251136060'],
        ];
    }
}
