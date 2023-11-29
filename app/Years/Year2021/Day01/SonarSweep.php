<?php declare(strict_types=1);

namespace App\Years\Year2021\Day01;

use App\IDay;
use App\Utils\Input;

class SonarSweep implements IDay
{
    public function runPart1(Input $data): string
    {
        $lastNumber = null;
        $increments = 0;

        foreach ($data->getAsArrayOfIntegers() as $number) {
            if ($lastNumber === null) {
                $lastNumber = $number;
                continue;
            }

            if ($number > $lastNumber) {
                $increments++;
            }

            $lastNumber = $number;
        }

        return (string) $increments;
    }

    public function runPart2(Input $data): string
    {
        $numbers = $data->getAsArrayOfIntegers();
        $lastSum = null;
        $increments = 0;

        $i = -1;
        while (isset($numbers[++$i + 2])) {
            $sum = $numbers[$i] + $numbers[$i + 1] + $numbers[$i + 2];

            if ($lastSum === null) {
                $lastSum = $sum;
                continue;
            }

            if ($sum > $lastSum) {
                $increments++;
            }

            $lastSum = $sum;
        }

        return (string) $increments;
    }

    public function getExpectedTestResult1(): string
    {
        return '7';
    }

    public function getExpectedTestResult2(): string
    {
        return '5';
    }
}