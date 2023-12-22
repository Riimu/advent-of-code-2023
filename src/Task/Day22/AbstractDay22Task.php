<?php

declare(strict_types=1);

namespace Riimu\AdventOfCode2023\Task\Day22;

use Riimu\AdventOfCode2023\TaskInputInterface;
use Riimu\AdventOfCode2023\TaskInterface;
use Riimu\AdventOfCode2023\Utility\Parse;

/**
 * @author Riikka Kalliomäki <riikka.kalliomaki@gmail.com>
 * @copyright Copyright (c) 2023 Riikka Kalliomäki
 * @license http://opensource.org/licenses/mit-license.php MIT License
 */
abstract class AbstractDay22Task implements TaskInterface
{
    final public function __construct() {}

    public static function createTask(): static
    {
        return new static();
    }

    public function parseInput(string $input): Day22Input
    {
        $bricks = [];

        foreach (Parse::lines($input) as $line) {
            [$startX, $startY, $startZ, $endX, $endY, $endZ] = Parse::ints($line);
            $bricks[] = new Brick(
                new BrickCoordinate($startX, $startY, $startZ),
                new BrickCoordinate($endX, $endY, $endZ)
            );
        }

        return new Day22Input($bricks);
    }

    public function solveTask(TaskInputInterface $input): string
    {
        if (!$input instanceof Day22Input) {
            throw new \InvalidArgumentException(sprintf("Unexpected input type '%s'", get_debug_type($input)));
        }

        return (string) $this->solve($input);
    }

    abstract protected function solve(Day22Input $input): int;

    /**
     * @param array<int, Brick> $initialBricks
     * @return BrickState
     */
    protected function simulateState(array $initialBricks): BrickState
    {
        $brickTops = [];

        /** @var array<int, array<int, Brick>> $brickList */
        $brickList = [];

        foreach ($initialBricks as $brick) {
            $brickList[$brick->getBottom()][] = $brick;

            foreach ($brick->iterateTop() as $coordinate) {
                $brickTops[$coordinate->z][$coordinate->y][$coordinate->x] = $brick;
            }
        }

        ksort($brickList);

        foreach ($brickList as $z => $bricks) {
            foreach ($bricks as $key => $brick) {
                $maxFall = 1;

                foreach ($brick->iterateBottom() as $coordinate) {
                    for ($i = $z - 1; $i > 0; $i--) {
                        if (isset($brickTops[$i][$coordinate->y][$coordinate->x])) {
                            $maxFall = max($maxFall, $i + 1);
                            break;
                        }
                    }
                }

                if ($maxFall !== $z) {
                    $fallenBrick = $brick->fallTo($maxFall);

                    foreach ($brick->iterateTop() as $coordinate) {
                        unset($brickTops[$coordinate->z][$coordinate->y][$coordinate->x]);
                    }

                    foreach ($fallenBrick->iterateTop() as $coordinate) {
                        $brickTops[$coordinate->z][$coordinate->y][$coordinate->x] = $fallenBrick;
                    }

                    $brickList[$maxFall][] = $fallenBrick;
                    unset($brickList[$z][$key]);
                }
            }
        }

        return new BrickState($brickTops, $brickList);
    }

    /**
     * @param Brick $brick
     * @param BrickState $state
     * @return array<int, Brick>
     */
    protected function getSupportedBricks(Brick $brick, BrickState $state): array
    {
        $supportedBricks = [];
        $z = $brick->getTop();

        foreach ($state->brickList[$z + 1] ?? [] as $supportedBrick) {
            $supports = [];

            foreach ($supportedBrick->iterateBottom() as $supported) {
                if (isset($state->brickTops[$z][$supported->y][$supported->x])) {
                    $supportingBrick = $state->brickTops[$z][$supported->y][$supported->x];

                    if (!\in_array($supportingBrick, $supports, true)) {
                        $supports[] = $supportingBrick;
                    }
                }
            }

            if ($supports === [$brick]) {
                $supportedBricks[] = $supportedBrick;
            }
        }

        return $supportedBricks;
    }
}
