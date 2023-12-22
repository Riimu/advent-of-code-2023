<?php

declare(strict_types=1);

namespace Riimu\AdventOfCode2023\Task\Day22;

/**
 * @author Riikka Kalliomäki <riikka.kalliomaki@gmail.com>
 * @copyright Copyright (c) 2023 Riikka Kalliomäki
 * @license http://opensource.org/licenses/mit-license.php MIT License
 */
class Day22Part1Task extends AbstractDay22Task
{
    protected function solve(Day22Input $input): int
    {
        $brickTops = [];

        /** @var array<int, array<int, Brick>> $brickList */
        $brickList = [];

        foreach ($input->bricks as $brick) {
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

        $canDisintegrate = 0;

        foreach ($brickList as $bricks) {
            foreach ($bricks as $brick) {
                $z = $brick->getTop();

                foreach ($brickList[$z + 1] ?? [] as $supportedBrick) {
                    $supports = [];

                    foreach ($supportedBrick->iterateBottom() as $supported) {
                        if (isset($brickTops[$z][$supported->y][$supported->x])) {
                            $supportingBrick = $brickTops[$z][$supported->y][$supported->x];

                            if (!\in_array($supportingBrick, $supports)) {
                                $supports[] = $supportingBrick;
                            }
                        }
                    }

                    if ($supports === [$brick]) {
                        continue 2;
                    }
                }

                $canDisintegrate++;
            }
        }

        return $canDisintegrate;
    }
}
