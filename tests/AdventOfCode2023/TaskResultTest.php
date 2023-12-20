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
            [Task\Day7\Day7Part2Task::class, __DIR__ . '/../../input/day-7-sample-1.txt', '5905'],
            [Task\Day7\Day7Part2Task::class, __DIR__ . '/../../input/day-7-input.txt', '249400220'],

            [Task\Day8\Day8Part1Task::class, __DIR__ . '/../../input/day-8-sample-1.txt', '2'],
            [Task\Day8\Day8Part1Task::class, __DIR__ . '/../../input/day-8-sample-2.txt', '6'],
            [Task\Day8\Day8Part1Task::class, __DIR__ . '/../../input/day-8-input.txt', '20777'],
            [Task\Day8\Day8Part2Task::class, __DIR__ . '/../../input/day-8-sample-3.txt', '6'],
            [Task\Day8\Day8Part2Task::class, __DIR__ . '/../../input/day-8-input.txt', '13289612809129'],

            [Task\Day9\Day9Part1Task::class, __DIR__ . '/../../input/day-9-sample-1.txt', '114'],
            [Task\Day9\Day9Part1Task::class, __DIR__ . '/../../input/day-9-input.txt', '2043183816'],
            [Task\Day9\Day9Part2Task::class, __DIR__ . '/../../input/day-9-sample-1.txt', '2'],
            [Task\Day9\Day9Part2Task::class, __DIR__ . '/../../input/day-9-input.txt', '1118'],

            [Task\Day10\Day10Part1Task::class, __DIR__ . '/../../input/day-10-sample-1.txt', '4'],
            [Task\Day10\Day10Part1Task::class, __DIR__ . '/../../input/day-10-sample-2.txt', '4'],
            [Task\Day10\Day10Part1Task::class, __DIR__ . '/../../input/day-10-sample-3.txt', '8'],
            [Task\Day10\Day10Part1Task::class, __DIR__ . '/../../input/day-10-sample-4.txt', '8'],
            [Task\Day10\Day10Part1Task::class, __DIR__ . '/../../input/day-10-input.txt', '6846'],
            [Task\Day10\Day10Part2Task::class, __DIR__ . '/../../input/day-10-sample-5.txt', '4'],
            [Task\Day10\Day10Part2Task::class, __DIR__ . '/../../input/day-10-sample-6.txt', '4'],
            [Task\Day10\Day10Part2Task::class, __DIR__ . '/../../input/day-10-sample-7.txt', '8'],
            [Task\Day10\Day10Part2Task::class, __DIR__ . '/../../input/day-10-sample-8.txt', '10'],
            [Task\Day10\Day10Part2Task::class, __DIR__ . '/../../input/day-10-input.txt', '325'],

            [Task\Day11\Day11Part1Task::class, __DIR__ . '/../../input/day-11-sample-1.txt', '374'],
            [Task\Day11\Day11Part1Task::class, __DIR__ . '/../../input/day-11-input.txt', '10033566'],
            [Task\Day11\Day11Part2Task::class, __DIR__ . '/../../input/day-11-input.txt', '560822911938'],

            [Task\Day12\Day12Part1Task::class, __DIR__ . '/../../input/day-12-sample-1.txt', '21'],
            [Task\Day12\Day12Part1Task::class, __DIR__ . '/../../input/day-12-input.txt', '7032'],
            [Task\Day12\Day12Part2Task::class, __DIR__ . '/../../input/day-12-sample-1.txt', '525152'],
            [Task\Day12\Day12Part2Task::class, __DIR__ . '/../../input/day-12-input.txt', '1493340882140'],

            [Task\Day13\Day13Part1Task::class, __DIR__ . '/../../input/day-13-sample-1.txt', '405'],
            [Task\Day13\Day13Part1Task::class, __DIR__ . '/../../input/day-13-input.txt', '30158'],
            [Task\Day13\Day13Part2Task::class, __DIR__ . '/../../input/day-13-sample-1.txt', '400'],
            [Task\Day13\Day13Part2Task::class, __DIR__ . '/../../input/day-13-input.txt', '36474'],

            [Task\Day14\Day14Part1Task::class, __DIR__ . '/../../input/day-14-sample-1.txt', '136'],
            [Task\Day14\Day14Part1Task::class, __DIR__ . '/../../input/day-14-input.txt', '111339'],
            [Task\Day14\Day14Part2Task::class, __DIR__ . '/../../input/day-14-sample-1.txt', '64'],
            [Task\Day14\Day14Part2Task::class, __DIR__ . '/../../input/day-14-input.txt', '93736'],

            [Task\Day15\Day15Part1Task::class, __DIR__ . '/../../input/day-15-sample-1.txt', '1320'],
            [Task\Day15\Day15Part1Task::class, __DIR__ . '/../../input/day-15-input.txt', '512797'],
            [Task\Day15\Day15Part2Task::class, __DIR__ . '/../../input/day-15-sample-1.txt', '145'],
            [Task\Day15\Day15Part2Task::class, __DIR__ . '/../../input/day-15-input.txt', '262454'],

            [Task\Day16\Day16Part1Task::class, __DIR__ . '/../../input/day-16-sample-1.txt', '46'],
            [Task\Day16\Day16Part1Task::class, __DIR__ . '/../../input/day-16-input.txt', '7979'],
            [Task\Day16\Day16Part2Task::class, __DIR__ . '/../../input/day-16-sample-1.txt', '51'],
            [Task\Day16\Day16Part2Task::class, __DIR__ . '/../../input/day-16-input.txt', '8437'],

            [Task\Day17\Day17Part1Task::class, __DIR__ . '/../../input/day-17-sample-1.txt', '102'],
            [Task\Day17\Day17Part1Task::class, __DIR__ . '/../../input/day-17-input.txt', '674'],
            [Task\Day17\Day17Part2Task::class, __DIR__ . '/../../input/day-17-sample-1.txt', '94'],
            [Task\Day17\Day17Part2Task::class, __DIR__ . '/../../input/day-17-sample-2.txt', '71'],
            [Task\Day17\Day17Part2Task::class, __DIR__ . '/../../input/day-17-input.txt', '773'],

            [Task\Day18\Day18Part1Task::class, __DIR__ . '/../../input/day-18-sample-1.txt', '62'],
            [Task\Day18\Day18Part1Task::class, __DIR__ . '/../../input/day-18-input.txt', '58550'],
            [Task\Day18\Day18Part2Task::class, __DIR__ . '/../../input/day-18-sample-1.txt', '952408144115'],
            [Task\Day18\Day18Part2Task::class, __DIR__ . '/../../input/day-18-input.txt', '47452118468566'],

            [Task\Day19\Day19Part1Task::class, __DIR__ . '/../../input/day-19-sample-1.txt', '19114'],
            [Task\Day19\Day19Part1Task::class, __DIR__ . '/../../input/day-19-input.txt', '383682'],
            [Task\Day19\Day19Part2Task::class, __DIR__ . '/../../input/day-19-sample-1.txt', '167409079868000'],
            [Task\Day19\Day19Part2Task::class, __DIR__ . '/../../input/day-19-input.txt', '117954800808317'],

            [Task\Day20\Day20Part1Task::class, __DIR__ . '/../../input/day-20-sample-1.txt', '32000000'],
            [Task\Day20\Day20Part1Task::class, __DIR__ . '/../../input/day-20-sample-2.txt', '11687500'],
            [Task\Day20\Day20Part1Task::class, __DIR__ . '/../../input/day-20-input.txt', '867118762'],
        ];
    }
}
