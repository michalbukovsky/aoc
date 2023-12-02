<?php

declare(strict_types=1);

namespace App\Years\Year2020\Day03;

use App\IDay;
use App\Utils\Input;

class Toboggan implements IDay
{
    private const INCREMENTS_2 = [
        ['x' => 1, 'y' => 1],
        ['x' => 3, 'y' => 1],
        ['x' => 5, 'y' => 1],
        ['x' => 7, 'y' => 1],
        ['x' => 1, 'y' => 2],
    ];

    public function runPart1(Input $data): string | int
    {
        return $this->getTreesHit($data->getAsArray(), 3, 1);
    }

    public function runPart2(Input $data): string | int
    {
        $treesHitMultiplied = 1;
        foreach (self::INCREMENTS_2 as $increments) {
            $treesHitMultiplied *= $this->getTreesHit($data->getAsArray(), $increments['x'], $increments['y']);
        }

        return $treesHitMultiplied;
    }

    protected function getTreesHit(array $data, int $xIncrement, int $yIncrement): int
    {
        $dataCount = count($data);
        $hitTrees = 0;

        // top left is 0,0
        $x = $xIncrement;
        for ($y = $yIncrement; $y < $dataCount; $y += $yIncrement) {
            if ($this->isTreeHit($x, $y, $data)) {
                $hitTrees++;
            }
            $x += $xIncrement;
        }

        return $hitTrees;
    }

    protected function isTreeHit(int $x, int $y, array $data): bool
    {
        $maxWidth = strlen($data[0]);
        $x %= $maxWidth;

        return substr($data[$y], $x, 1) === '#';
    }

    public function getExpectedTestResult1(): ?string
    {
        return '7';
    }

    public function getExpectedTestResult2(): ?string
    {
        return '336';
    }
}
