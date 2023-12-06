<?php

declare(strict_types=1);

namespace Riimu\AdventOfCode2023;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * @author Riikka Kalliomäki <riikka.kalliomaki@gmail.com>
 * @copyright Copyright (c) 2023 Riikka Kalliomäki
 * @license http://opensource.org/licenses/mit-license.php MIT License
 */
class GenerateTaskCommand extends Command
{
    private const TEMPLATE_FILES = [
        __DIR__ . '/../template/task/AbstractDayTask.txt',
        __DIR__ . '/../template/task/DayInput.txt',
        __DIR__ . '/../template/task/DayPart1Task.txt',
        __DIR__ . '/../template/task/DayPart2Task.txt',
    ];

    protected function configure(): void
    {
        $this
            ->setName('generate-task')
            ->setDescription('Generates task files for a new day puzzle')
            ->addArgument('day-number', InputArgument::REQUIRED, 'Number of the day to generate');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $number = $input->getArgument('day-number');

        if (!\is_string($number)) {
            throw new \UnexpectedValueException(sprintf("Unexpected day number type '%s'", get_debug_type($number)));
        }

        $taskDir = __DIR__ . '/Task/Day' . $number;

        if (is_dir($taskDir)) {
            throw new \RuntimeException("Tasks already exist for the day '$number'");
        }

        if (!mkdir($taskDir) || !is_dir($taskDir)) {
            throw new \RuntimeException("Could not create task directory '$taskDir'");
        }

        foreach (self::TEMPLATE_FILES as $template) {
            $this->renderTemplate($template, $taskDir, $number);
        }

        touch(__DIR__ . '/../input/' . sprintf('day-%s-sample-1.txt', $number));

        $output->writeln('Created task files at ' . realpath($taskDir));

        return Command::SUCCESS;
    }

    private function renderTemplate(string $file, string $target, string $number): void
    {
        $contents = file_get_contents($file);

        if (!\is_string($contents)) {
            throw new \RuntimeException("Could not read template file '$file'");
        }

        $targetFile = strtr(basename($file), [
            'Day' => 'Day' . $number,
            '.txt' => '.php',
        ]);

        file_put_contents($target . '/' . $targetFile, strtr($contents, [
            '{{NUMBER}}' => $number,
        ]));
    }
}
