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

    protected function configure()
    {
        $this
            ->setName(sprintf('task:%s', substr($this->taskClass, strrpos($this->taskClass, '\\') + 1)))
            ->setDescription('Runs the task and prints out the solutions')
            ->addArgument('input-file', InputArgument::REQUIRED, 'Path to the task input file');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $task = $this->createTask();
        $output->writeln($task->solveTask($task->parseInput($this->readInput($input->getArgument('input-file')))));

        return Command::SUCCESS;
    }

    private function createTask(): TaskInterface
    {
        return new $this->taskClass();
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
