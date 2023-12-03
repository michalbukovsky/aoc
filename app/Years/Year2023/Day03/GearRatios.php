<?php declare(strict_types=1);

namespace App\Years\Year2023\Day03;

use App\IDay;
use App\Utils\Grid;
use App\Utils\Input;

class GearRatios implements IDay
{
    public function runPart1(Input $data): string | int
    {
        $grid = Grid::initByInput($data);
        $validNumbers = [];

        foreach ($grid->getRows() as $y => $row) {
            $lastNumber = null;
            $isLastNumberValid = false;

            foreach ($row as $x => $item) {
                if (is_numeric($item)) {
                    $lastNumber .= $item;
                    foreach ($grid->getNeighborsDiagonal($x, $y) as $neighborValue) {
                        if (!is_numeric($neighborValue) && $neighborValue !== '.') {
                            $isLastNumberValid = true;
                        }
                    }
                }

                if (!is_numeric($item) || !$grid->isSet($x + 1, $y)) {
                    if ($lastNumber && $isLastNumberValid) {
                        $validNumbers[] = $lastNumber;
                    }

                    $lastNumber = null;
                    $isLastNumberValid = false;
                }
            }
        }

        return array_sum($validNumbers);
    }

    public function runPart2(Input $data): string | int
    {
        $grid = Grid::initByInput($data);
        $gears = [];

        foreach ($grid->getRows() as $y => $row) {
            $lastNumber = null;
            $lastGearCoords = null;

            foreach ($row as $x => $item) {
                if (is_numeric($item)) {
                    $lastNumber .= $item;

                    if ($lastGearCoords === null) {
                        foreach ($grid->getNeighborsDiagonal($x, $y) as $neighborCoords => $neighborValue) {
                            if ($neighborValue === '*') {
                                $lastGearCoords = $neighborCoords;
                            }
                        }
                    }
                }

                if (!is_numeric($item) || !$grid->isSet($x + 1, $y)) {
                    if ($lastGearCoords) {
                        $gears[$lastGearCoords][] = $lastNumber;
                        $lastGearCoords = null;
                    }

                    $lastNumber = null;
                }
            }
        }

        $sum = 0;
        foreach ($gears as $numbers) {
            if (count($numbers) !== 2) {
                continue;
            }

            $sum += array_product($numbers);
        }

        return $sum;
    }

    public function getExpectedTestResult1(): ?string
    {
        return '4361';
    }

    public function getExpectedTestResult2(): ?string
    {
        return '467835';
    }
}
