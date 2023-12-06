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
            $parent = $file->getPathInfo();

            if (!$parent instanceof \SplFileInfo) {
                throw new \UnexpectedValueException(sprintf("No parent returned for path '%s'", $file->getPathname()));
            }

            $className = sprintf(
                '%s\Task\%s\%s',
                __NAMESPACE__,
                $parent->getBasename(),
                $file->getFilenameWithoutExtension()
            );

            if (class_exists($className)) {
                $this->processFoundClass($className);
            }
        }
    }

    /**
     * @param class-string $class
     * @return void
     */
    private function processFoundClass(string $class): void
    {
        if (!is_a($class, TaskInterface::class, true)) {
            return;
        }

        $reflection = new \ReflectionClass($class);

        if ($reflection->isAbstract()) {
            return;
        }

        $this->add(new TaskRunnerCommand($class));
    }
}
