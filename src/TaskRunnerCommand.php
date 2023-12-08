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
 * @template T of TaskInputInterface
 */
class TaskRunnerCommand extends Command
{
    /** @var class-string<TaskInterface> */
    private string $taskClass;

    /**
     * @param class-string<TaskInterface> $taskClass
     */
    public function __construct(string $taskClass)
    {
        $this->taskClass = $taskClass;

        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->setName(sprintf('task:%s', substr($this->taskClass, strrpos($this->taskClass, '\\') + 1, -4)))
            ->setDescription('Runs the task and prints out the solutions')
            ->addArgument('input-file', InputArgument::REQUIRED, 'Path to the task input file');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $inputFile = $input->getArgument('input-file');

        if (!\is_string($inputFile)) {
            throw new \UnexpectedValueException('Unexpected input file value');
        }

        $timer = hrtime(true);
        $task = $this->createTask($this->taskClass);
        $output->writeln($task->solveTask($task->parseInput($this->readInput($inputFile))));
        $output->writeln(sprintf('Total runtime: %.3f ms', (hrtime(true) - $timer) / 1e6));

        return Command::SUCCESS;
    }

    /**
     * @param class-string<TaskInterface> $taskClass
     * @return TaskInterface
     */
    private function createTask(string $taskClass): TaskInterface
    {
        return $taskClass::createTask();
    }

    private function readInput(string $filename): string
    {
        if (!is_file($filename)) {
            throw new \RuntimeException(sprintf("The file '%s' does not exist", $filename));
        }

        $contents = file_get_contents($filename);

        if (!\is_string($contents)) {
            throw new \UnexpectedValueException(sprintf("Could not read the file '%s'", $filename));
        }

        return $contents;
    }
}
