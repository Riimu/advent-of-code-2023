<?php

declare(strict_types=1);

namespace Riimu\AdventOfCode2023;

use Symfony\Component\Finder\Finder;

/**
 * @author Riikka Kalliomäki <riikka.kalliomaki@gmail.com>
 * @copyright Copyright (c) 2023 Riikka Kalliomäki
 * @license http://opensource.org/licenses/mit-license.php MIT License
 */
class Application extends \Symfony\Component\Console\Application
{
    public function __construct()
    {
        parent::__construct();

        $this->registerTaskCommands();
    }

    private function registerTaskCommands(): void
    {
        $finder = new Finder();
        $finder->in(__DIR__ . '/Task')->name('*Task.php');

        foreach ($finder as $file) {
            $class = sprintf(
                '%s\Task\%s\%s',
                __NAMESPACE__,
                $file->getPathInfo()->getBasename(),
                $file->getFilenameWithoutExtension()
            );

            if (is_a($class, TaskInterface::class, true)) {
                $this->add(new TaskRunnerCommand($class));
            }
        }
    }
}
