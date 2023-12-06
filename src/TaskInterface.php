<?php

declare(strict_types=1);

namespace Riimu\AdventOfCode2023;

/**
 * @author Riikka Kalliomäki <riikka.kalliomaki@gmail.com>
 * @copyright Copyright (c) 2023 Riikka Kalliomäki
 * @license http://opensource.org/licenses/mit-license.php MIT License
 */
interface TaskInterface
{
    public static function createTask(): static;
    public function parseInput(string $input): TaskInputInterface;
    public function solveTask(TaskInputInterface $input): string;
}
