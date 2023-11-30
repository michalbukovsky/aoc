<?php declare(strict_types = 1);

namespace App\Years\Year2022\Day08;

use App\IDay;
use App\Utils\Input;
use App\Utils\Tools;
use App\Utils\Vector2Int;

class TreetopTreeHouse implements IDay
{
    /** @var array<int, array<int, bool>> */
    private array $visibleTrees;


    public function runPart1(Input $data): string
    {
        $this->visibleTrees = [];
        $trees = $data->getAsArrayOfArraysOfChars();

        $this->markVisibleHorizontal($trees);
        $this->markVisibleHorizontal($trees, true);
        $this->markVisibleVertical($trees);
        $this->markVisibleVertical($trees, true);

        return (string) Tools::arraySum2D($this->visibleTrees);
    }


    public function runPart2(Input $data): string
    {
        $trees = $data->getAsArrayOfArraysOfChars();
        $treeScenicScores = [];
        $count = count($trees);

        for ($row = 1; $row < $count - 1; $row++) {
            for ($col = 1; $col < $count - 1; $col++) {
                $treeScenicScores[$row][$col] =
                    $this->getVisibleTrees($trees, new Vector2Int($col, $row), new Vector2Int(0, -1))
                    * $this->getVisibleTrees($trees, new Vector2Int($col, $row), new Vector2Int(1, 0))
                    * $this->getVisibleTrees($trees, new Vector2Int($col, $row), new Vector2Int(0, 1))
                    * $this->getVisibleTrees($trees, new Vector2Int($col, $row), new Vector2Int(-1, 0));
            }
        }

        return (string) Tools::arrayMax2D($treeScenicScores, false);
    }


    public function getExpectedTestResult1(): ?string
    {
        return '21';
    }


    public function getExpectedTestResult2(): ?string
    {
        return '8';
    }


    private function markVisibleHorizontal(array $trees, bool $reverse = false): void
    {
        foreach ($trees as $rowIndex => $row) {
            $highest = -1;
            if ($reverse) {
                $row = array_reverse($row, true);
            }

            foreach ($row as $colIndex => $height) {
                if ($height > $highest) {
                    $this->visibleTrees[$rowIndex][$colIndex] = true;
                    $highest = $height;
                }
            }
        }
    }


    private function markVisibleVertical(array $trees, bool $reverse = false): void
    {
        $count = count($trees);
        $start = $reverse ? $count - 1 : 0;
        $step = $reverse ? -1 : 1;

        for ($col = 0; $col < $count; $col++) {
            $highest = -1;
            for ($row = $start; $row < $count && $row >= 0; $row += $step) {
                $height = $trees[$row][$col];
                if ($height > $highest) {
                    $this->visibleTrees[$row][$col] = true;
                    $highest = $height;
                }
            }
        }
    }


    private function getVisibleTrees(array $trees, Vector2Int $start, Vector2Int $direction): int
    {
        $visibleTrees = 0;
        $y = $start->getY();
        $x = $start->getX();
        $startHeight = $trees[$y][$x];

        do {
            $y += $direction->getY();
            $x += $direction->getX();

            $tree = $trees[$y][$x] ?? null;
            if ($tree === null) {
                return $visibleTrees;
            }

            ++$visibleTrees;

            if ($tree >= $startHeight) {
                return $visibleTrees;
            }
        } while (true);
    }

}
