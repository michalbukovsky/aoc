<?php

declare(strict_types=1);

namespace App\Years\Year2020\Day10;

use App\IDay;
use App\Utils\Input;

class Joltage implements IDay
{
    // :)
    protected const POSSIBILITIES_PER_GROUP_SIZE = [
        1 => 1,
        2 => 1,
        3 => 2,
        4 => 4,
        5 => 7,
    ];

    public function runPart1(Input $data): string | int
    {
        $dataAsInt = $this->getDataAsInt($data);

        $differences = [];
        $lastJoltage = 0;
        foreach ($dataAsInt as $joltage) {
            $diff = $joltage - $lastJoltage;
            $differences[$diff]++;
            $lastJoltage = $joltage;
        }

        $differences[3]++;

        return $differences[1] * $differences[3];
    }

    public function runPart2(Input $data): string | int
    {
        $dataAsInt = $this->getDataAsInt($data);
        $dataCount = count($dataAsInt);
        array_unshift($dataAsInt, 0);

        $possibilities = 1;
        $i = 0;
        $groupSize = 0;
        foreach ($dataAsInt as $item) {
            $groupSize++;
            if ($dataAsInt[$i + 1] - $item > 1 || $i === $dataCount) {
                $possibilities *= self::POSSIBILITIES_PER_GROUP_SIZE[$groupSize];
                $groupSize = 0;
            }
            $i++;
        }

        return $possibilities;
    }

    public function getExpectedTestResult1(): ?string
    {
        return '220';
    }

    public function getExpectedTestResult2(): ?string
    {
        return '19208';
    }

    private function getDataAsInt(Input $data): array
    {
        $dataAsInt = $data->getAsArrayOfIntegers();
        sort($dataAsInt);

        return $dataAsInt;
    }
}
