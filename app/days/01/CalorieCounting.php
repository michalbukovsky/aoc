<?php declare(strict_types = 1);

namespace App;

use App\Utils\Input;

class CalorieCounting implements IDay
{
    public function runPart1(Input $data): string
    {
        $highestSum = 0;

        foreach ($data->getAsArrayOfArrays(false, "\n\n", "\n") as $group) {
            $currentSum = 0;
            foreach ($group as $item) {
                $currentSum += (int) $item;
            }

            $highestSum = max($highestSum, $currentSum);
        }

        return (string) $highestSum;
    }


    public function runPart2(Input $data): string
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

        return (string) ($sums[0] + $sums[1] + $sums[2]);
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
