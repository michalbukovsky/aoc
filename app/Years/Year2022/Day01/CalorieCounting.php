<?php declare(strict_types=1);

namespace App\Years\Year2022\Day01;

use App\IDay;
use App\Utils\Input;

class CalorieCounting implements IDay
{
    public function runPart1(Input $data): string | int
    {
        $highestSum = 0;

        foreach ($data->getAsArrayOfArrays(false, "\n\n", "\n") as $group) {
            $currentSum = 0;
            foreach ($group as $item) {
                $currentSum += (int) $item;
            }

            $highestSum = max($highestSum, $currentSum);
        }

        return $highestSum;
    }

    public function runPart2(Input $data): string | int
    {
        $sums = [];

        foreach ($data->getAsArrayOfArrays(false, "\n\n", "\n") as $group) {
            $currentSum = 0;
            foreach ($group as $item) {
                $currentSum += (int) $item;
            }

            $sums[] = $currentSum;
        }

        rsort($sums);

        return $sums[0] + $sums[1] + $sums[2];
    }

    public function getExpectedTestResult1(): ?string
    {
        return '24000';
    }

    public function getExpectedTestResult2(): ?string
    {
        return '45000';
    }
}
