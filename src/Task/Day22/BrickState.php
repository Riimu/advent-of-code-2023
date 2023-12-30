<?php

declare(strict_types=1);

namespace Riimu\AdventOfCode2023\Task\Day22;

/**
 * @author Riikka Kalliomäki <riikka.kalliomaki@gmail.com>
 * @copyright Copyright (c) 2023 Riikka Kalliomäki
 * @license http://opensource.org/licenses/mit-license.php MIT License
 */
readonly class BrickState
{
    /**
     * @param array<int, array<int, array<int, Brick>>> $brickTops
     * @param array<int, array<int, Brick>> $brickList
     */
    public function __construct(
        public array $brickTops,
        public array $brickList,
        public int $changes = 0
    ) {}

    public static function createFromInput(Day22Input $input): self
    {
        $brickTops = [];
        $brickList = [];

        foreach ($input->bricks as $brick) {
            $brickList[$brick->bottom->z][] = $brick;

            foreach ($brick->getCeilingCoordinates() as $coordinate) {
                $brickTops[$coordinate->z][$coordinate->y][$coordinate->x] = $brick;
            }
        }

        ksort($brickList);

        return new BrickState($brickTops, $brickList);
    }

    public function removeBrick(Brick $brick): self
    {
        $brickTops = $this->brickTops;
        $brickList = $this->brickList;
        $key = array_search($brick, $brickList[$brick->bottom->z], true);

        if ($key === false) {
            throw new \RuntimeException('Unexpected brick');
        }

        unset($brickList[$brick->bottom->z][$key]);

        foreach ($brick->getCeilingCoordinates() as $coordinate) {
            unset($brickTops[$coordinate->z][$coordinate->y][$coordinate->x]);
        }

        return new BrickState($brickTops, $brickList, $this->changes);
    }
}
