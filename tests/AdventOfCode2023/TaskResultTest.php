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
            'day01-1' => [Task\Day1\Day1Part1Task::class, __DIR__ . '/../../input/day-1-sample-1.txt', '142'],
            'day01-2' => [Task\Day1\Day1Part1Task::class, __DIR__ . '/../../input/day-1-input.txt', '55090'],
            'day01-3' => [Task\Day1\Day1Part2Task::class, __DIR__ . '/../../input/day-1-sample-2.txt', '281'],
            'day01-4' => [Task\Day1\Day1Part2Task::class, __DIR__ . '/../../input/day-1-input.txt', '54845'],

            'day02-1' => [Task\Day2\Day2Part1Task::class, __DIR__ . '/../../input/day-2-sample-1.txt', '8'],
            'day02-2' => [Task\Day2\Day2Part1Task::class, __DIR__ . '/../../input/day-2-input.txt', '2810'],
            'day02-3' => [Task\Day2\Day2Part2Task::class, __DIR__ . '/../../input/day-2-sample-1.txt', '2286'],
            'day02-4' => [Task\Day2\Day2Part2Task::class, __DIR__ . '/../../input/day-2-input.txt', '69110'],

            'day03-1' => [Task\Day3\Day3Part1Task::class, __DIR__ . '/../../input/day-3-sample-1.txt', '4361'],
            'day03-2' => [Task\Day3\Day3Part1Task::class, __DIR__ . '/../../input/day-3-input.txt', '535351'],
            'day03-3' => [Task\Day3\Day3Part2Task::class, __DIR__ . '/../../input/day-3-sample-1.txt', '467835'],
            'day03-4' => [Task\Day3\Day3Part2Task::class, __DIR__ . '/../../input/day-3-input.txt', '87287096'],

            'day04-1' => [Task\Day4\Day4Part1Task::class, __DIR__ . '/../../input/day-4-sample-1.txt', '13'],
            'day04-2' => [Task\Day4\Day4Part1Task::class, __DIR__ . '/../../input/day-4-input.txt', '19855'],
            'day04-3' => [Task\Day4\Day4Part2Task::class, __DIR__ . '/../../input/day-4-sample-1.txt', '30'],
            'day04-4' => [Task\Day4\Day4Part2Task::class, __DIR__ . '/../../input/day-4-input.txt', '10378710'],

            'day05-1' => [Task\Day5\Day5Part1Task::class, __DIR__ . '/../../input/day-5-sample-1.txt', '35'],
            'day05-2' => [Task\Day5\Day5Part1Task::class, __DIR__ . '/../../input/day-5-input.txt', '621354867'],
            'day05-3' => [Task\Day5\Day5Part2Task::class, __DIR__ . '/../../input/day-5-sample-1.txt', '46'],
            'day05-4' => [Task\Day5\Day5Part2Task::class, __DIR__ . '/../../input/day-5-input.txt', '15880236'],

            'day06-1' => [Task\Day6\Day6Part1Task::class, __DIR__ . '/../../input/day-6-sample-1.txt', '288'],
            'day06-2' => [Task\Day6\Day6Part1Task::class, __DIR__ . '/../../input/day-6-input.txt', '128700'],
            'day06-3' => [Task\Day6\Day6Part2Task::class, __DIR__ . '/../../input/day-6-sample-1.txt', '71503'],
            'day06-4' => [Task\Day6\Day6Part2Task::class, __DIR__ . '/../../input/day-6-input.txt', '39594072'],

            'day07-1' => [Task\Day7\Day7Part1Task::class, __DIR__ . '/../../input/day-7-sample-1.txt', '6440'],
            'day07-2' => [Task\Day7\Day7Part1Task::class, __DIR__ . '/../../input/day-7-input.txt', '251136060'],
            'day07-3' => [Task\Day7\Day7Part2Task::class, __DIR__ . '/../../input/day-7-sample-1.txt', '5905'],
            'day07-4' => [Task\Day7\Day7Part2Task::class, __DIR__ . '/../../input/day-7-input.txt', '249400220'],

            'day08-1' => [Task\Day8\Day8Part1Task::class, __DIR__ . '/../../input/day-8-sample-1.txt', '2'],
            'day08-2' => [Task\Day8\Day8Part1Task::class, __DIR__ . '/../../input/day-8-sample-2.txt', '6'],
            'day08-3' => [Task\Day8\Day8Part1Task::class, __DIR__ . '/../../input/day-8-input.txt', '20777'],
            'day08-4' => [Task\Day8\Day8Part2Task::class, __DIR__ . '/../../input/day-8-sample-3.txt', '6'],
            'day08-5' => [Task\Day8\Day8Part2Task::class, __DIR__ . '/../../input/day-8-input.txt', '13289612809129'],

            'day09-1' => [Task\Day9\Day9Part1Task::class, __DIR__ . '/../../input/day-9-sample-1.txt', '114'],
            'day09-2' => [Task\Day9\Day9Part1Task::class, __DIR__ . '/../../input/day-9-input.txt', '2043183816'],
            'day09-3' => [Task\Day9\Day9Part2Task::class, __DIR__ . '/../../input/day-9-sample-1.txt', '2'],
            'day09-4' => [Task\Day9\Day9Part2Task::class, __DIR__ . '/../../input/day-9-input.txt', '1118'],

            'day10-1' => [Task\Day10\Day10Part1Task::class, __DIR__ . '/../../input/day-10-sample-1.txt', '4'],
            'day10-2' => [Task\Day10\Day10Part1Task::class, __DIR__ . '/../../input/day-10-sample-2.txt', '4'],
            'day10-3' => [Task\Day10\Day10Part1Task::class, __DIR__ . '/../../input/day-10-sample-3.txt', '8'],
            'day10-4' => [Task\Day10\Day10Part1Task::class, __DIR__ . '/../../input/day-10-sample-4.txt', '8'],
            'day10-5' => [Task\Day10\Day10Part1Task::class, __DIR__ . '/../../input/day-10-input.txt', '6846'],
            'day10-6' => [Task\Day10\Day10Part2Task::class, __DIR__ . '/../../input/day-10-sample-5.txt', '4'],
            'day10-7' => [Task\Day10\Day10Part2Task::class, __DIR__ . '/../../input/day-10-sample-6.txt', '4'],
            'day10-8' => [Task\Day10\Day10Part2Task::class, __DIR__ . '/../../input/day-10-sample-7.txt', '8'],
            'day10-9' => [Task\Day10\Day10Part2Task::class, __DIR__ . '/../../input/day-10-sample-8.txt', '10'],
            'day10-10' => [Task\Day10\Day10Part2Task::class, __DIR__ . '/../../input/day-10-input.txt', '325'],

            'day11-1' => [Task\Day11\Day11Part1Task::class, __DIR__ . '/../../input/day-11-sample-1.txt', '374'],
            'day11-2' => [Task\Day11\Day11Part1Task::class, __DIR__ . '/../../input/day-11-input.txt', '10033566'],
            'day11-3' => [Task\Day11\Day11Part2Task::class, __DIR__ . '/../../input/day-11-input.txt', '560822911938'],

            'day12-1' => [Task\Day12\Day12Part1Task::class, __DIR__ . '/../../input/day-12-sample-1.txt', '21'],
            'day12-2' => [Task\Day12\Day12Part1Task::class, __DIR__ . '/../../input/day-12-input.txt', '7032'],
            'day12-3' => [Task\Day12\Day12Part2Task::class, __DIR__ . '/../../input/day-12-sample-1.txt', '525152'],
            'day12-4' => [Task\Day12\Day12Part2Task::class, __DIR__ . '/../../input/day-12-input.txt', '1493340882140'],

            'day13-1' => [Task\Day13\Day13Part1Task::class, __DIR__ . '/../../input/day-13-sample-1.txt', '405'],
            'day13-2' => [Task\Day13\Day13Part1Task::class, __DIR__ . '/../../input/day-13-input.txt', '30158'],
            'day13-3' => [Task\Day13\Day13Part2Task::class, __DIR__ . '/../../input/day-13-sample-1.txt', '400'],
            'day13-4' => [Task\Day13\Day13Part2Task::class, __DIR__ . '/../../input/day-13-input.txt', '36474'],

            'day14-1' => [Task\Day14\Day14Part1Task::class, __DIR__ . '/../../input/day-14-sample-1.txt', '136'],
            'day14-2' => [Task\Day14\Day14Part1Task::class, __DIR__ . '/../../input/day-14-input.txt', '111339'],
            'day14-3' => [Task\Day14\Day14Part2Task::class, __DIR__ . '/../../input/day-14-sample-1.txt', '64'],
            'day14-4' => [Task\Day14\Day14Part2Task::class, __DIR__ . '/../../input/day-14-input.txt', '93736'],

            'day15-1' => [Task\Day15\Day15Part1Task::class, __DIR__ . '/../../input/day-15-sample-1.txt', '1320'],
            'day15-2' => [Task\Day15\Day15Part1Task::class, __DIR__ . '/../../input/day-15-input.txt', '512797'],
            'day15-3' => [Task\Day15\Day15Part2Task::class, __DIR__ . '/../../input/day-15-sample-1.txt', '145'],
            'day15-4' => [Task\Day15\Day15Part2Task::class, __DIR__ . '/../../input/day-15-input.txt', '262454'],

            'day16-1' => [Task\Day16\Day16Part1Task::class, __DIR__ . '/../../input/day-16-sample-1.txt', '46'],
            'day16-2' => [Task\Day16\Day16Part1Task::class, __DIR__ . '/../../input/day-16-input.txt', '7979'],
            'day16-3' => [Task\Day16\Day16Part2Task::class, __DIR__ . '/../../input/day-16-sample-1.txt', '51'],
            'day16-4' => [Task\Day16\Day16Part2Task::class, __DIR__ . '/../../input/day-16-input.txt', '8437'],

            'day17-1' => [Task\Day17\Day17Part1Task::class, __DIR__ . '/../../input/day-17-sample-1.txt', '102'],
            'day17-2' => [Task\Day17\Day17Part1Task::class, __DIR__ . '/../../input/day-17-input.txt', '674'],
            'day17-3' => [Task\Day17\Day17Part2Task::class, __DIR__ . '/../../input/day-17-sample-1.txt', '94'],
            'day17-4' => [Task\Day17\Day17Part2Task::class, __DIR__ . '/../../input/day-17-sample-2.txt', '71'],
            'day17-5' => [Task\Day17\Day17Part2Task::class, __DIR__ . '/../../input/day-17-input.txt', '773'],

            'day18-1' => [Task\Day18\Day18Part1Task::class, __DIR__ . '/../../input/day-18-sample-1.txt', '62'],
            'day18-2' => [Task\Day18\Day18Part1Task::class, __DIR__ . '/../../input/day-18-input.txt', '58550'],
            'day18-3' => [Task\Day18\Day18Part2Task::class, __DIR__ . '/../../input/day-18-sample-1.txt', '952408144115'],
            'day18-4' => [Task\Day18\Day18Part2Task::class, __DIR__ . '/../../input/day-18-input.txt', '47452118468566'],

            'day19-1' => [Task\Day19\Day19Part1Task::class, __DIR__ . '/../../input/day-19-sample-1.txt', '19114'],
            'day19-2' => [Task\Day19\Day19Part1Task::class, __DIR__ . '/../../input/day-19-input.txt', '383682'],
            'day19-3' => [Task\Day19\Day19Part2Task::class, __DIR__ . '/../../input/day-19-sample-1.txt', '167409079868000'],
            'day19-4' => [Task\Day19\Day19Part2Task::class, __DIR__ . '/../../input/day-19-input.txt', '117954800808317'],

            'day20-1' => [Task\Day20\Day20Part1Task::class, __DIR__ . '/../../input/day-20-sample-1.txt', '32000000'],
            'day20-2' => [Task\Day20\Day20Part1Task::class, __DIR__ . '/../../input/day-20-sample-2.txt', '11687500'],
            'day20-3' => [Task\Day20\Day20Part1Task::class, __DIR__ . '/../../input/day-20-input.txt', '867118762'],
            'day20-4' => [Task\Day20\Day20Part2Task::class, __DIR__ . '/../../input/day-20-input.txt', '217317393039529'],

            'day21-1' => [Task\Day21\Day21Part1Task::class, __DIR__ . '/../../input/day-21-input.txt', '3682'],
            'day21-2' => [Task\Day21\Day21Part2Task::class, __DIR__ . '/../../input/day-21-input.txt', '609012263058042'],

            'day22-1' => [Task\Day22\Day22Part1Task::class, __DIR__ . '/../../input/day-22-sample-1.txt', '5'],
            'day22-2' => [Task\Day22\Day22Part1Task::class, __DIR__ . '/../../input/day-22-input.txt', '517'],
            'day22-3' => [Task\Day22\Day22Part2Task::class, __DIR__ . '/../../input/day-22-sample-1.txt', '7'],
            'day22-4' => [Task\Day22\Day22Part2Task::class, __DIR__ . '/../../input/day-22-input.txt', '61276'],

            'day23-1' => [Task\Day23\Day23Part1Task::class, __DIR__ . '/../../input/day-23-sample-1.txt', '94'],
            'day23-2' => [Task\Day23\Day23Part1Task::class, __DIR__ . '/../../input/day-23-input.txt', '2438'],
            'day23-3' => [Task\Day23\Day23Part2Task::class, __DIR__ . '/../../input/day-23-sample-1.txt', '154'],
            'day23-4' => [Task\Day23\Day23Part2Task::class, __DIR__ . '/../../input/day-23-input.txt', '6658'],

            'day24-1' => [Task\Day24\Day24Part1Task::class, __DIR__ . '/../../input/day-24-input.txt', '17906'],
            'day24-2' => [Task\Day24\Day24Part2Task::class, __DIR__ . '/../../input/day-24-input.txt', '571093786416929'],

            'day25-1' => [Task\Day25\Day25Part1Task::class, __DIR__ . '/../../input/day-25-sample-1.txt', '54'],
            'day25-2' => [Task\Day25\Day25Part1Task::class, __DIR__ . '/../../input/day-25-input.txt', '54'],
        ];
    }
}
