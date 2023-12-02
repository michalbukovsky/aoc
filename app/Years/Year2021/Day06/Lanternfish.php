<?php declare(strict_types = 1);

namespace App\Years\Year2021\Day06;

use App\IDay;
use App\Utils\Input;

class Lanternfish implements IDay
{
    public function runPart1(Input $data): string | int
    {
        return $this->simulate($data, 80);
    }


    public function runPart2(Input $data): string | int
    {
        return $this->simulate($data, 256);
    }


    private function simulate(Input $data, int $days): string
    {
        $day = 1;
        $fishesByDay = [];
        foreach ($data->getFirstLineAsIntegers() as $fishInt) {
            $fishesByDay[$fishInt]++;
        }

        do {
            ksort($fishesByDay);

            for ($daysToReproduction = 0; $daysToReproduction <= 9; $daysToReproduction++) {
                $fishes = $fishesByDay[$daysToReproduction] ?? 0;
                if ($fishes === 0) {
                    continue;
                }

                if ($daysToReproduction === 0) {
                    $fishesByDay[9] = $fishes;
                    $fishesByDay[7] += $fishes;
                    $fishesByDay[0] = 0;
                    continue;
                }

                $fishesByDay[$daysToReproduction - 1] += $fishes;
                $fishesByDay[$daysToReproduction] -= $fishes;
            }
        } while (++$day <= $days);

        return (string)array_sum($fishesByDay);
    }


    public function getExpectedTestResult1(): ?string
    {
        return '5934';
    }


    public function getExpectedTestResult2(): ?string
    {
        return '26984457539';
    }
}
