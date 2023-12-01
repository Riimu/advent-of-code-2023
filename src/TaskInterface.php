<?php

declare(strict_types=1);

namespace Riimu\AdventOfCode2023;

/**
 * @author Riikka Kalliomäki <riikka.kalliomaki@gmail.com>
 * @copyright Copyright (c) 2023 Riikka Kalliomäki
 * @license http://opensource.org/licenses/mit-license.php MIT License
 * @template T of TaskInputInterface
 */
interface TaskInterface
{
    /**
     * @return static
     */
    public static function createTask(): static;

    /**
     * @param string $input
     * @return T
     */
    public function parseInput(string $input): TaskInputInterface;

    /**
     * @param T $input
     * @return string
     */
    public function solveTask(TaskInputInterface $input): string;
}
