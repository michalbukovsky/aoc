<?php

declare(strict_types=1);

namespace App\Years\Year2020\Day15;

use App\IDay;
use App\Utils\Input;

class Recitation implements IDay
{
    public function __construct()
    {
        ini_set('memory_limit', '4G');
    }

    public function runPart1(Input $data): string | int
    {
        return $this->play($data, 2020);
    }

    public function runPart2(Input $data): string | int
    {
        return $this->play($data, 30000000);
    }

    protected function play(Input $data, int $end): string | int
    {
        $dataAsArray = [];
        $i = 1;
        foreach ($data->getFirstLineAsIntegers() as $number) {
            $dataAsArray[$number] = [$i];
            $i++;
        }

        end($dataAsArray);
        $lastSpoken = key($dataAsArray);
        $time = count($dataAsArray);

        while (true) {
            $time++;
            if (isset($dataAsArray[$lastSpoken][1])) {
                $lastSpoken = $dataAsArray[$lastSpoken][1] - $dataAsArray[$lastSpoken][0];
            } else {
                $lastSpoken = 0;
            }

            $dataAsArray[$lastSpoken][] = $time;
            if (isset($dataAsArray[$lastSpoken][2])) {
                array_shift($dataAsArray[$lastSpoken]);
            }

            if ($time % 10000 === 0) {
                echo "$time: $lastSpoken\n";
            }

            if ($time === $end) {
                return $lastSpoken;
            }
        }
    }

    public function getExpectedTestResult1(): ?string
    {
        return '436';
    }

    public function getExpectedTestResult2(): ?string
    {
        return '175594';
    }
}
