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

        /** @var array<int, array<int, Brick>> $brickList */
        $brickList = [];

        foreach ($input->bricks as $brick) {
            $brickList[$brick->getBottom()][] = $brick;

            foreach ($brick->iterateTop() as $coordinate) {
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

        $z = $brick->getBottom();
        $key = array_search($brick, $brickList[$z], true);

        unset($brickList[$z][$key]);

        foreach ($brick->iterateTop() as $coordinate) {
            unset($brickTops[$coordinate->z][$coordinate->y][$coordinate->x]);
        }

        return new BrickState($brickTops, $brickList, $this->changes);
    }
}
